<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estrategia extends Model
{
    use HasFactory;

    protected  $table = 'estrategias';

    protected $fillable = [
       'periodo_id',
       'hecho_id',
       'politica_id',
       'nombre',
       'peso',
       'descripcion'
    ];

    public function periodo(){
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function hecho(){
        return $this->belongsTo(Hecho::class, 'hecho_id');
    }

    public function politica(){
        return $this->belongsTo(Politica::class, 'periodo_id');
    }

    public function programas(){
        return $this->hasMany(Programa::class, 'estrategia_id');
    }
}
