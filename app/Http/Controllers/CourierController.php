<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourierController extends Controller
{
    public function index()
    {
        return view('admin.courier.courier-view');
    }

    public function getCourier()
    {
        $couriers = Courier::orderBy('created_at','desc')->get();
        return response()->json($couriers);
    }

    public function show($id)
    {
        $courier = Courier::find($id);
        return response()->json($courier);
    }

    public function store(Request $request)
    {
         $request->merge([
            'shiping_cost' => str_replace('.', '', $request->shiping_cost),
        ]);
        $validator = Validator::make($request->all(), [
            'courier_name' => 'required|string|max:255',
            'shiping_cost' => 'required|numeric|min:0',
         ]);
         if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
          Courier::create([
            'courier_name' => strtoupper($request->courier_name),
            'shiping_cost' => strtoupper($request->shiping_cost)
        ]);

        return response()->json([
            'message' => 'Category saved successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'shiping_cost' => str_replace('.', '', $request->shiping_cost),
        ]);
        $validator = Validator::make($request->all(), [
            'courier_name' => 'required|string|max:255',
            'shiping_cost' => 'required|numeric|min:0',
         ]);
         if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
        $courier = Courier::findOrFail($id);
        $courier->update([
            'courier_name' => $request->courier_name,
            'shiping_cost' => $request->shiping_cost,
        ]);
        return response()->json(['message' => 'Courier updated successfully']);
    }

    public function destroy($id)
    {
        $courier = Courier::find($id);

        if (!$courier) {
            return response()->json(['message' => 'courier not found'], 404);
        }

        $courier->delete();

         return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }
}
