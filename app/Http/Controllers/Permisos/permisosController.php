<?php

namespace App\Http\Controllers\Permisos;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisosController extends Controller
{
    public function index(){
        return view('permisos.index');
    }

    public function get(){
        return response()->json(['status' => true, 'permisos' => Permission::get()]);
    }

    public function getData(Permission $permisos){
        return response()->json(['permisos' => $permisos]);
    }

    public function update(Permission $permisos, Request $request){
        $permisos->update($request->all());
        $permisos->save();
        return response()->json(['saved' => true]);
    }


    public function store(Request $request){
        $permisos = Permission::create($request->post());
        return response()->json([
            'permisos'=>$permisos
        ]);
    }

    public function delete(Permission $permisos){
        $permisos->delete();
        return response()->json(['status' => true]);
    }

}
