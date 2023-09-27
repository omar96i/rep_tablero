<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaDeProducto extends Model
{
    use HasFactory;

    protected $table = 'meta_de_productos';

    protected $fillable = [
        'periodo_id',
        'hecho_id',
        'politica_id',
        'estrategia_id',
        'programa_id',
        'indicador_id',
        'user_id',
        'codigo',
        'nombre',
        'indicador_meta',
        'siglas_indicador',
        'peso',
        'linea_base',
        'year',
        'meta_year_1',
        'meta_year_2',
        'meta_year_3',
        'meta_year_4',
        'ejecucion_year_1',
        'ejecucion_year_2',
        'ejecucion_year_3',
        'ejecucion_year_4',
        'meta_cuatrienio',
        'recurso_year_1',
        'recurso_year_2',
        'recurso_year_3',
        'recurso_year_4',
        'recurso_cuatrienio',
    ];

    public function hecho()
    {
        return $this->belongsTo(Hecho::class, 'hecho_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function politica()
    {
        return $this->belongsTo(Politica::class, 'politica_id');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programa_id');
    }

    public function indicador()
    {
        return $this->belongsTo(Indicador::class, 'indicador_id');
    }

    public function hoja_de_vida()
    {
        return $this->hasOne(MetaDeProductoHojaDeVida::class, 'meta_producto_id');
    }

    public function user_asignado()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proyectos()
    {
        return $this->hasMany(ProyectoProducto::class, 'meta_producto_id');
    }

    public function reportes()
    {
        return $this->hasMany(MetaDeProductoReporte::class, 'meta_producto_id');
    }

    public function cantMetaAños()
    {
        $cant = 0;
        $campos = ['meta_year_1', 'meta_year_2', 'meta_year_3', 'meta_year_4',];
        foreach ($campos as $campo) {
            if (!empty($this->$campo)) {
                $cant++;
            }
        }
        return $cant;
    }

    public function avanceFisico()
    {
        // listar los 4 reportes de cada año
        $meta = $this;
        $meta_programada = 0;
        $numero_metas_programadas = $this->cantMetaAños();
        $programacion_meta = collect(range(1, 4))->map(function ($año) use ($meta, &$meta_programada, $numero_metas_programadas) {
            $year = intval(($meta->year) - 1) + $año;
            $prop = 'meta_year_' . $año;

            if ($meta->indicador_id == 1) {
                $meta_programada += $meta->{$prop} / $numero_metas_programadas;
            }else{
                $meta_programada = $meta->{$prop};
            }

            $filteredReportes = $meta->reportes->map(function ($reporte) use ($year, &$meta_programada) {
                $reporte_calculado = [];

                if (intval($reporte->meta_año) == $year && $meta_programada != 0) {
                    $reporte_calculado['año'] = $year;
                    $reporte_calculado['meta_programada'] = $meta_programada;
                    $reporte_calculado['meta_alcanzada'] = $reporte->meta_alcanzada;
                    $reporte_calculado['porcentaje_avance'] = ($reporte->meta_alcanzada * 100) / $meta_programada;
                }

                return empty($reporte_calculado) ? null : $reporte_calculado;
            })->filter(); // Filtrar los objetos nulos

            if ($filteredReportes->isEmpty()) {
                // Si no se encontraron objetos que cumplan la condición, devolver algo por defecto
                return (object)['año' => $year, 'meta_programada' => $meta_programada, 'meta_alcanzada' => 0, 'porcentaje_avance' => 0];
            }

            return $filteredReportes->first(); // Devolver el primer objeto que cumple la condición
        })->toArray();

        return $programacion_meta;
    }
}
