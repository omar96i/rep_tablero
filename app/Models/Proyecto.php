<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'hecho_id',
        'politica_id',
        'estrategia_id',
        'programa_id',
        'periodo_id',
        'vigencia',
        'nombre',
    ];

    public function hecho(){
        return $this->belongsTo(Hecho::class);
    }

    public function politica(){
        return $this->belongsTo(Politica::class);
    }

    public function programa(){
        return $this->belongsTo(Programa::class);
    }

    public function periodo(){
        return $this->belongsTo(Periodo::class);
    }

    public function productos(){
        return $this->hasMany(ProyectoProducto::class);
    }

    public function presupuestos(){
        return $this->hasMany(ProyectoPresupuesto::class);
    }
}
