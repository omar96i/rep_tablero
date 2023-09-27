<?php

namespace App\Http\Controllers\Metas;

use App\Http\Controllers\Controller;
use App\Models\MetaDeProductoReporte;
use App\Models\ReportesArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenciasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $nombreArchivo = $archivo->getClientOriginalName();
                $carpetaDestino = $this->obtenerCarpetaDestino($request->input('tipo'));
                $rutaArchivo = $archivo->storeAs($carpetaDestino, $nombreArchivo, 'public');

                // guardar registro
                ReportesArchivo::create([
                    'reporte_id' => $request->reporte_id,
                    'tipo' => $request->tipo,
                    'route_name' => $nombreArchivo
                ]);
            }
            return response()->json(['status' => true, 'message' => 'Evidencia cargada con éxito']);
        }else{
            return response()->json(['status' => true, 'message' => "no tengo archivo"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MetaDeProductoReporte $reporte){
        $reporte->load('evidencias');
        $evidencias = $reporte->evidencias;

        return response()->json(['evidencias' => $evidencias]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(ReportesArchivo $evidencia)
    {
        Storage::disk('public')->delete($this->obtenerCarpetaDestino($evidencia->tipo) . '/' . $evidencia->route_name);

        $evidencia->delete();

        return response()->json(['status' => true, 'message' => 'Eliminado correctamente.']);
    }

    public function descargar($id_file)
    {
        $archivo = ReportesArchivo::find($id_file);

        if (Storage::disk('public')->exists($this->obtenerCarpetaDestino($archivo->tipo) . '/' . $archivo->route_name)) {
            return Storage::disk('public')->download($this->obtenerCarpetaDestino($archivo->tipo) . '/' . $archivo->route_name);
        } else {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }
    }

    protected function obtenerCarpetaDestino($tipo)
    {
        if ($tipo === 'imagen') {
            return 'imagenes';
        } elseif ($tipo === 'documento') {
            return 'documentos';
        } elseif ($tipo === 'video') {
            return 'videos';
        } else {
            return 'otros';
        }
    }
}
