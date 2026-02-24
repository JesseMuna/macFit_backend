<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use League\Config\Exception\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:40',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:4|max:15|confirmed',
            'user_image'=>'nullable|image|max:255|mimes:jpeg,png,jpg',

        ]);

        if($request->role_id){
            $role_id = $request->role_id;
        }
        else{
            $role = Role::where('name', 'User')->first();
            $role_id = $role->id;
        }  
        
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $role->id;
        $user->is_active = 1; 
        $user->password = Hash::make($validated['password']);

         if($request->hasfile('user_image')){
             $filename = $request->file('user_image')->store('users','public');
         }else{
             $filename = null;
         }
         $user->user_image = $filename;

        try{
            $user->save();

            $signedUrl = URL::temporarySignedRoute(
            'verification.verify', 
            now()->addMinutes(60),
        
            [
                'id' => $user->id,
                'hash' => sha1($user->email)
            ]
        );

        $user->notify(new VerifyEmailNotification($signedUrl));

        return response()->json([
            'message' => 'verification Email resent successfully'
        ],200);
         

        }

        catch(\Exception $exception){
            return response()->json([
                'error'=>"Registration Failed",
                'message'=> $exception->getMessage()
            ]);

        }
    }
    public function login(Request $request){
        $validated = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string|min:4'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user|| !Hash::check($validated['password'], $user->password))
            //throw ValidationException::withMessage([
                //'error'=>'Invalid credentials'], 401);
            return response()->json([
                'error'=>'Invalid credentials'
            ],401);


            if(!$user->is_active){
                return response()->json([
                    'message'=>'Your account is not active please verify email address'
                ],403);
            }
        $token = $user->createToken("auth-token")->plainTextToken;
        return response()->json([
        'Message'=>'Login Successful!',
        'token'=>$token,
        'user'=>$user,
        'abilities'=>$user->abilities(),
        ], 201);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json('Logut Successful');
        
    }
}
