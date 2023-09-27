<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaDeProductoHojaDeVida extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_producto_id',
        'linea_base',
        'periocidad',
        'fuente',
        'periodo_fuente',
        'localizacion',
        'poblacion',
        'definiciones',
        'valoracion',
        'medicion',
        'unidad_medida',
        'formula',
        'variables',
        'observaciones',
    ];

    public function meta(){
        return $this->belongsTo(MetaDeProducto::class, 'meta_producto_id');
    }
}
