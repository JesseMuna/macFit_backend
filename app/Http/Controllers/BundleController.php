<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function createBundle(Request $request){
        $validated = $request->validate([
        'name'=>'required|string',
        'start_time'=>'required',
        'duration'=>'required',
        'description'=>'string|max: 1000',
        'category_id'=>'integer|exists:categories,id'

         ]);

        $bundle = new Bundle();
        $bundle->name = $validated['name'];
        $bundle->start_time = $validated['start_time'];
        $bundle->duration = $validated['duration'];
        $bundle->description = $validated['description'];
        $bundle->category_id = $validated['category_id'];



        try{
            $bundle->save();
            return response()->json($bundle);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save bundle',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readAllBundles(){
        try{
            //$bundles = Bundle::all();
            $bundles = Bundle::join('categories','bundles.category_id','=', 'categories.id')
                        ->select('bundles.*', 'categories.name as category_name')
                        ->get();
            return response()->json($bundles);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save bundle',
                'message'=>$exception->getMessage()

            ]);
        }
    }

    public function readBundle($id){
        try{

            //$bundle =Bundle::findOrFail($id);
             $bundle = Bundle::join('categories','bundles.category_id','=', 'categories.id')
                        ->select('bundles.*', 'categories.name as category_name')
                        ->where('bundle.id', $id)
                        ->first();
            return response()->json($bundle);
        }
       catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch bundle','$id',
                'message'=>$exception->getMessage()

            ]);
    }

    }

    public function updateBundle(Request $request, $id){
        
        $validated = $request->validate(['name'=>'required|string',
        'start_time'=>'required|dateTime',
        'duration'=>'required|time',
        'description'=>'string|max: 1000',
        'category_id'=>'integer|exists:categories,id'

            ]);

        try{
            $bundle = Bundle::findOrFail($id);

            $bundle->name = $validated['name'];
            $bundle->start_time = $validated['start_time'];
            $bundle->duration = $validated['duration'];
            $bundle->description = $validated['description'];
            $bundle->category_id = $validated['category_id'];


            }
            catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch bundle','$id',
                'message'=>$exception->getMessage()

            ]);
    }
    }
    public function deleteBundle($id){
        try{
            $bundle= Bundle::findOrFail($id);
            $bundle->delete();
            return response("Bundle deleted succefully");

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete  bundle','$id',
                'message'=>$exception->getMessage()

            ]);
        
    }
    }
}
