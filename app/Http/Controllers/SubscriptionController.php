<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function createSubscription(Request $request){
        $validated = $request->validate([
        'user_id'=>'required|string',
        'bundle_id'=>'integer|exists:bundles,id',
        'description'=>'nullable|string|max: 1000'

         ]);

        $subscription = new Subscription();
        $subscription->name = $validated['name'];
        $subscription->name = $validated['description'];

        try{
            $subscription->save();
            return response()->json($subscription);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save subscription',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readAllSubscriptions(){
        try{
            $subscriptions = Subscription::all();
            return response()->json($subscriptions);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save subscription',
                'message'=>$exception->getMessage()

            ]);
        }
    }

    public function readSubscription($id){
        try{
            $subscription =Subscription::findOrFail($id);
            return response()->json($subscription);
        }
       catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch subscription','$id',
                'message'=>$exception->getMessage()

            ]);
    }

    }

    public function updateSubscription(Request $request, $id){
        
        $validated = $request->validate([
        'user_id'=>'required|string',
        'bundle_id'=>'integer|exists:bundles,id',
        'description'=>'nullable|string|max: 1000'

         ]);

        try{
                $existingSubscription = Subscription::findOrFail($id);

                $existingSubscription->name = $validated['name'];
                $existingSubscription->description = $validated['description'];
                $existingSubscription->save();
                return response ()->json($existingSubscription);

            }
            catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch subscription','$id',
                'message'=>$exception->getMessage()

            ]);
    }
    }
    public function deleteSubscription($id){
        try{
            $subscription= Subscription::findOrFail($id);
            $subscription->delete();
            return response("Subscription deleted succefully");

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete  subscription','$id',
                'message'=>$exception->getMessage()

            ]);
        
    }
    }
}
