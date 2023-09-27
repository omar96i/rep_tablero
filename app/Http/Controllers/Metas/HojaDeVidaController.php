<?php

namespace App\Http\Controllers\Metas;

use App\Http\Controllers\Controller;
use App\Models\MetaDeProductoHojaDeVida;
use Illuminate\Http\Request;

class HojaDeVidaController extends Controller
{
    public function store(Request $request){
        $hoja_vida = MetaDeProductoHojaDeVida::create($request->all());

        return response()->json(['status' => true, 'message' => 'Creado correctamente.', 'hoja_vida' => $hoja_vida]);
    }

    public function update(Request $request, $id){
        MetaDeProductoHojaDeVida::find($id)->update($request->all());

        return response()->json(['status' => true, 'message' => 'Actualizado correctamente.']);
    }
}
