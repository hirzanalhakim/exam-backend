<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnitRumah;

class ProductController extends Controller
{
    //
    function createUnit(Request $request){
        DB::beginTransaction();

        try{
            $this->validate($request, [
            'kavling' => 'required',
            'blok' => 'required',
            'nomor_rumah' => 'required',
            'harga' => 'required',
            'luas_tanah' => 'required',
            'luas_bangunan' => 'required'
            ]);

            $kavling = $request->input('kavling');
            $blok = $request->input('blok');
            $nomor_rumah = $request->input('nomor_rumah');
            $harga = $request->input('harga');
            $luas_tanah = $request->input('luas_tanah');
            $luas_bangunan = $request->input('luas_bangunan');

            $unit = new UnitRumah;
            $unit->kavling = $kavling;
            $unit->blok = $blok;
            $unit->nomor_rumah = $nomor_rumah;
            $unit->harga = $harga;
            $unit->luas_tanah = $luas_tanah;
            $unit->luas_bangunan = $luas_bangunan;
            $unit->save();

            $unitrumah = UnitRumah::get();

            DB::commit(); // data tidak akan di insert sebelum di commit
            return response()->json($unitrumah, 200);
        }
        catch(\Exception $e){

            DB::rollback(); //untuk rollback data ketika data yang dimasukkan mengalami kegagalan
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    function deleteUnit(Request $request){
        DB::beginTransaction();
        try{
            $this->validate($request, [
                'id' => 'required',
            ]);


            $id = $request->input('id');
            $delete = DB::delete('delete from unit where id = ?', [$id]);


            $unitrumah = UnitRumah::get();

            DB::commit();
            return response()->json($unitrumah, 200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(["message" => $e->getMessage()], 500);
        }

    }
}
