<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo_id',
        'hecho_id',
        'politica_id',
        'estrategia_id',
        'nombre',
        'peso',
        'descripcion',
    ];

    public function periodo(){
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function hecho(){
        return $this->belongsTo(Hecho::class, 'hecho_id');
    }

    public function politica(){
        return $this->belongsTo(Politica::class, 'politica_id');
    }

    public function estrategia(){
        return $this->belongsTo(Estrategia::class, 'estrategia_id');
    }

    public function meta_productos(){
        return $this->hasMany(MetaDeProducto::class, 'programa_id');
    }
}
