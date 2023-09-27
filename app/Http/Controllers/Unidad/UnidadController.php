<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Models\Unidad;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function index(){
        return view('unidades.index');
    }

    public function get(){
        return response()->json(['status' => true, 'unidad' => Unidad::get()]);
    }
    public function getData(Unidad $unidad){
        return response()->json(['unidad' => $unidad]);
    }
    public function update(Unidad $unidad, Request $request){
        $unidad->update($request->all());
        $unidad->save();
        return response()->json(['status' => true]);
    }


    public function store(Request $request){
        $unidad = Unidad::create($request->post());
        return response()->json([
            'status' => true,
            'unidad'=>$unidad
        ]);
    }

    public function delete(Unidad $unidad){
        $unidad->delete();
        return response()->json(['status' => true]);
    }

}
