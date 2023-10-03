<?php

namespace App\Http\Controllers\Metas;

use App\Http\Controllers\Controller;
use App\Models\MetaDeProducto;
use App\Models\MetaDeProductoReporte;
use App\Models\MetaDeProductosGrafica;
use App\Models\Periodo;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MetaDeProducto $meta)
    {
        $meta->load('indicador', 'proyectos.proyecto', 'hoja_de_vida');
        // listar los 4 reportes de cada año
        $meta->programacion_meta = $meta->avanceFisico();
    
        return view('ejecucion_metas.show', ['meta' => $meta]);
    }

    public function indexData(MetaDeProducto $meta)
    {
        $meta->load('indicador', 'proyectos.proyecto', 'hoja_de_vida');
        // listar los 4 reportes de cada año
        $meta->programacion_meta = $meta->avanceFisico();
        foreach ($meta->programacion_meta as $programacion_meta) {
            $student = MetaDeProductosGrafica::updateOrCreate(
                ['meta_producto_id' => $programacion_meta->meta_producto_id, 'year' => $programacion_meta->year],
                [
                    'meta_programada'=> $programacion_meta->meta_programada,
                    'meta_alcanzada'=> $programacion_meta->meta_alcanzada,
                    'porcentaje_avance'=> $programacion_meta->porcentaje_avance
                ]
            );
        }
    
        return response()->json(['meta' => $meta]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MetaDeProductoReporte::create($request->all());

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
        $reportes = MetaDeProductoReporte::where('meta_producto_id', $id)->get();

        return response()->json(['status' => true, 'reportes' => $reportes]);
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
        MetaDeProductoReporte::find($id)->update($request->all());

        return response()->json(['status' => true, 'message' => 'Actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($reporte)
    {
        MetaDeProductoReporte::find($reporte)->delete();

        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }
}
