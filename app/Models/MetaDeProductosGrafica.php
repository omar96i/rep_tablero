<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaDeProductosGrafica extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'meta_producto_id',
        'year',
        'meta_programada',
        'meta_alcanzada',
        'porcentaje_avance',
        'porcentaje_avance_general',
    ];
 
    public function meta(){
        return $this->hasOne(MetaDeProducto::class, 'meta_producto_id');
    }
}
