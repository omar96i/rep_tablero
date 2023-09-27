<?php

namespace App\Http\Controllers\Metas;

use App\Http\Controllers\Controller;
use App\Models\Indicador;
use App\Models\MetaDeProducto;
use App\Models\Periodo;
use Illuminate\Http\Request;

class MetasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo_activo = Periodo::getPeriodoActivo(auth()->user()->id);
        return view('programacion.metas.index', compact('periodo_activo'));
    }

    public function indexEjecucion(){
        $periodo_activo = Periodo::getPeriodoActivo(auth()->user()->id);
        return view('ejecucion_metas.index', compact('periodo_activo'));
    }
    
    public function get()
    {
        $metas = MetaDeProducto::with('hecho', 'politica', 'programa', 'periodo', 'indicador')->get();
    
        return response()->json(['metas' => $metas]);
    }

    public function indexData(Request $request)
    {
        $metas = MetaDeProducto::with('hecho', 'politica', 'programa', 'periodo')
                    ->where('user_id', auth()->user()->id)
                    ->where('hecho_id', $request->hecho_id)
                    ->where('politica_id', $request->politica_id)
                    // ->where('estrategia_id', $request->estrategia_id)
                    ->where('programa_id', $request->programa_id)
                    ->get();
        return response()->json(['metas' => $metas]);
    }

    public function getIndicadores()
    {
        $indicadores = Indicador::all();

        return response()->json(['indicadores' => $indicadores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MetaDeProducto::create($request->all());

        return response()->json(['status' => true, 'message' => 'Creado correctamente.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        MetaDeProducto::find($id)->update($request->all());

        return response()->json(['status' => true, 'message' => 'Actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MetaDeProducto::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }
}
