<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use League\Config\Exception\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:40',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:4|max:15|confirmed'

        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->password = Hash::make($validated['password']);

        try{
            $user->save();
            return response()->json($user);

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

                $token = $user->createToken("auth-token")->plainTextToken;

                return response()->json([
                'Message'=>'Login Successful!',
                'token'=>$token,
                'user'=>$user

                ], 201);
    }
}
