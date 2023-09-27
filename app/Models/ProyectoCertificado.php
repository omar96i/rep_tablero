<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoCertificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_presupuesto_id',
        'valor',
    ];

    public function movimiento(){
        return $this->belongsTo(ProyectoPresupuesto::class);
    }
}
