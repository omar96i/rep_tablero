<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hecho extends Model
{
    use HasFactory;

    protected $table = 'hechos';

    protected $fillable = [
        'periodo_id',
        'nombre',
        'peso',
        'descripcion',
    ];

    public function periodo(){
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function politicas(){
        return $this->hasMany(Politica::class, 'hecho_id');
    }

    public function estrategias(){
        return $this->hasMany(Estrategia::class, 'hecho_id');
    }

    public function programas(){
        return $this->hasMany(Programa::class, 'programa_id');
    }

    public function meta_productos(){
        return $this->hasMany(MetaDeProducto::class, 'hecho_id');
    }
}
