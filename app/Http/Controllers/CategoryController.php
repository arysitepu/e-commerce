<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
     public function index()
     {
        return view('admin.category.index');
     }

     public function getCategory()
     {
         $categories = Category::orderBy('created_at','desc')->get();
         return response()->json($categories);
     }

    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'required|string',
         ]);
          if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
        Category::create([
            'name' => $request->category_name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Category saved successfully'
        ]);
    }

    public function getDetail($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'description' => 'required|string',
         ]);
          if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->category_name,
            'description' => $request->description,
        ]);
        return response()->json(['message' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
         $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

         return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }
}
