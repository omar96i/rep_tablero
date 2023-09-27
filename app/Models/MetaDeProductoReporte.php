<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaDeProductoReporte extends Model
{
    use HasFactory;

    protected $fillable = [
       'meta_producto_id',
       'meta_año',
       'fecha_reporte',
       'meta_alcanzada',
       'actividad',
    ];

    public function meta(){
        return $this->belongsTo(MetaDeProducto::class);
    }

    public function evidencias(){
        return $this->hasMany(ReportesArchivo::class, 'reporte_id');
    }
}
