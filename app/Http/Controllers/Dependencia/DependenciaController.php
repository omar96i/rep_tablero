<?php

namespace App\Http\Controllers\Dependencia;

use App\Http\Controllers\Controller;
use App\Models\Dependencia;
use Illuminate\Http\Request;

class DependenciaController extends Controller
{
    public function index(){
        return view('dependencias.index');
    }

    public function get(){
        return response()->json(['status' => true, 'dependencia' => Dependencia::get()]);
    }
    public function getData(Dependencia $dependencia){
        return response()->json(['dependencia' => $dependencia]);
    }
    public function update(Dependencia $dependencia, Request $request){
        $dependencia->update($request->all());
        $dependencia->save();
        return response()->json(['saved' => true]);
    }


    public function store(Request $request){
        $dependencia = Dependencia::create($request->post());
        return response()->json([
            'status' => true,
            'dependencia'=>$dependencia
        ]);
    }

    public function delete(Dependencia $dependencia){
        $dependencia->delete();
        return response()->json(['status' => true]);
    }

}
