<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $validated = $request->validate([
        'name'=>'required|string|unique:categories,name',
        'description'=>'nullable|string|max: 1000'

         ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->name = $validated['description'];

        try{
            $category->save();
            return response()->json($category);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save category',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readAllCategories(){
        try{
            $categorys = Category::all();
            return response()->json($categorys);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to save category',
                'message'=>$exception->getMessage()

            ]);
        }
    }

    public function readCategory($id){
        try{
            $category =Category::findOrFail($id);
            return response()->json($category);
        }
       catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch category','$id',
                'message'=>$exception->getMessage()

            ]);
    }

    }

    public function updateCategory(Request $request, $id){
        
        $validated = $request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string|max: 1000'

            ]);

        try{
                $existingCategory = Category::findOrFail($id);

                $existingCategory->name = $validated['name'];
                $existingCategory->description = $validated['description'];
                $existingCategory->save();
                return response ()->json($existingCategory);

            }
            catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to fetch category','$id',
                'message'=>$exception->getMessage()

            ]);
    }
    }
    public function deleteCategory($id){
        try{
            $category= Category::findOrFail($id);
            $category->delete();
            return response("Category deleted succefully");

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=> 'Failed to delete  category','$id',
                'message'=>$exception->getMessage()

            ]);
        
    }
    }
}
