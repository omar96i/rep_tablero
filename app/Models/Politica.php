<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{
    use HasFactory;

    protected $fillable = [
        'periodo_id',
        'hecho_id',
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

    public function programas(){
        return $this->hasMany(Programa::class, 'politica_id');
    }

    public function meta_productos(){
        return $this->hasMany(MetaDeProducto::class, 'politica_id');
    }
}
