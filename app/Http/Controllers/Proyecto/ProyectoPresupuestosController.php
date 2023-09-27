<?php

namespace App\Http\Controllers\Proyecto;

use App\Http\Controllers\Controller;
use App\Models\ProyectoMovimientoFinanciero;
use App\Models\ProyectoPresupuesto;
use Illuminate\Http\Request;

class ProyectoPresupuestosController extends Controller
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

    public function getPresupuesto($id)
    {
        $presupuesto = ProyectoPresupuesto::where('id', $id)->with('proyecto', 'movimiento_financieros')->first();
        $total = 0;
        foreach ($presupuesto->movimiento_financieros as $movimiento) {
            if ($movimiento->tipo_movimiento == 'adicion' || 
                $movimiento->tipo_movimiento == 'creditos' || 
                $movimiento->tipo_movimiento == 'inicial') {
                $total += $movimiento->valor;
            } elseif ($movimiento->tipo_movimiento == 'reduccion' || 
                      $movimiento->tipo_movimiento == 'contracreditos') {
                $total -= $movimiento->valor;
            }
            $movimiento->total = $total;
        }
        

        return response()->json(['status' => true, 'presupuesto' => $presupuesto]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $presupuesto = ProyectoPresupuesto::create($request->all());
        // insertar primer movimiento
        $movimiento = new ProyectoMovimientoFinanciero();
        $movimiento->proyecto_presupuesto_id = $presupuesto->id;
        $movimiento->tipo_movimiento = 'inicial';
        $movimiento->valor = $presupuesto->inicial;
        $movimiento->save();

        $presupuesto->definitivo = ProyectoMovimientoFinanciero::TotalMovimientos($presupuesto->id);
        $presupuesto->save();

        return response()->json(['status' => true, 'message' => 'Creado correctamente.']);
    }

    // public function savePresupuestoColumn(Request $request)
    // {

    // }

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
        ProyectoPresupuesto::find($id)->update($request->all());

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
        ProyectoPresupuesto::find($id)->delete();

        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }
}
