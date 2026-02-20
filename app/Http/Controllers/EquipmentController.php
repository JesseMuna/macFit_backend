<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function createEquipment(Request $request){
        $validated = $request->validate([
        'name'=>'required|string',
        'usage'=>'required|string',
        'model_no'=>'required|integer',
        'status'=>'string|max: 1000',
        'value'=>'string|max: 1000'


         ]);

        $equipment = new Equipment();
        $equipment->name = $validated['name'];
        $equipment->longitude = $validated['longitude'];
        $equipment->latitude = $validated['latitude'];
        $equipment->description = $validated['description'];

        try{
            $equipment->save();
            return response()->json($equipment);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save equipment',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readAllEquipments(){
        try{
            $equipments = Equipment::all();
            return response()->json($equipments);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save equipment',
                'message'=>$exception->getMessage()

            ]);
        }
    }

    public function readEquipment($id){
        try{
            $equipment =Equipment::findOrFail($id);
            return response()->json($equipment);
        }
       catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch equipment','$id',
                'message'=>$exception->getMessage()

            ]);
    }

    }

    public function updateEquipment(Request $request, $id){
        
         $validated = $request->validate([
        'name'=>'required|string',
        'usage'=>'required|string',
        'model_no'=>'required|integer',
        'status'=>'string|max: 1000',
        'value'=>'string|max: 1000'

            ]);

        try{
                $equipment = Equipment::findOrFail($id);

                $equipment->name = $validated['name'];
                $equipment->longitude = $validated['longitude'];
                $equipment->latitude = $validated['latitude'];
                $equipment->save();
                return response ()->json($equipment);

            }
            catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch equipment','$id',
                'message'=>$exception->getMessage()

            ]);
    }
    }
    public function deleteEquipment($id){
        try{
            $equipment= Equipment::findOrFail($id);
            $equipment->delete();
            return response("Equipment deleted succefully");

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete  equipment','$id',
                'message'=>$exception->getMessage()

            ]);
        
    }
    }
}
