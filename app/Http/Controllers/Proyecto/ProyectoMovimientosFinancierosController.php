<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use App\Models\ProyectoMovimientoFinanciero;
use App\Models\ProyectoPresupuesto;
use Illuminate\Http\Request;

class ProyectoMovimientosFinancierosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movimiento = ProyectoMovimientoFinanciero::create($request->all());
        
        $presupuesto = ProyectoPresupuesto::where('id', $movimiento->proyecto_presupuesto_id)->first();
        $presupuesto->definitivo = ProyectoMovimientoFinanciero::TotalMovimientos($presupuesto->id);
        $presupuesto->save();

        return response()->json(['status' => true, 'message' => 'Creado correctamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        ProyectoMovimientoFinanciero::find($id)->update($request->all());

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
        $movimiento = ProyectoMovimientoFinanciero::find($id);
        $movimiento->delete();
        
        $presupuesto = ProyectoPresupuesto::find($movimiento->proyecto_presupuesto_id);
        $presupuesto->definitivo = ProyectoMovimientoFinanciero::TotalMovimientos($presupuesto->id);
        $presupuesto->save();

        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }
}
