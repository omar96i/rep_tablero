<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportesArchivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporte_id',
        'tipo',
        'route_name',
    ];

    public function reporte(){
        return $this->belongsTo(MetaDeProductoReporte::class, 'reporte_id');
    }


}
