<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RekeningController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('nama', 'asc')->get();
        $data = [
            'banks' => $banks
        ];
        return view('admin.rekening.rekening-view', $data);
    }

    public function Rekenings()
    {
        $rekenings = Rekening::with('bank')->orderBy('created_at','desc')->get();
        return response()->json($rekenings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required|numeric',
            'no_rek' => 'required|numeric',
            'nama_rek' => 'required|string',
         ]);
          if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
         Rekening::create([
            'bank_id' => $request->bank_id,
            'no_rek' => $request->no_rek,
            'nama_rek' => strtoupper($request->nama_rek)
        ]);
        return response()->json([
            'message' => 'Rekening saved successfully'
        ]);
    }

    public function show($id)
    {
        $rekening = Rekening::find($id);
        return response()->json($rekening);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required|numeric',
            'no_rek' => 'required|numeric',
            'nama_rek' => 'required|string',
         ]);
          if($validator->fails()){
             return response()->json([
                'errors' =>  $validator->errors()
            ], 400);
         }
        $rekening = Rekening::find($id);
        $rekening->bank_id = $request->bank_id;
        $rekening->no_rek = $request->no_rek;
        $rekening->nama_rek = $request->nama_rek;
        $rekening->save();
        return response()->json([
            'message' => 'Rekening update successfully'
        ]);

    }

    public function destroy($id)
    {
        $rekening = Rekening::find($id);
        if (!$rekening) {
            return response()->json(['message' => 'rekening not found'], 404);
        }
        $rekening->delete();
        return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }


}
