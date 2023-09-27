<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodos';

    protected $fillable = [
        'nombre',
        'fecha_ini',
        'fecha_fin',
        'estado',
    ];

    public function users(){
        return $this->hasMany(UserPeriodo::class, 'periodo_id');
    }

    public function hechos(){
        return $this->hasMany(Hecho::class, 'periodo_id');
    }

    public function politicas(){
        return $this->hasMany(Politica::class, 'periodo_id');
    }

    public function estrategias(){
        return $this->hasMany(Estrategias::class, 'periodo_id');
    }

    public function programas(){
        return $this->hasMany(Programa::class, 'periodo_id');
    }

    public function metas(){
        return $this->hasMany(MetaDeProducto::class, 'periodo_id');
    }

    public static function getPeriodoActivo($user_id){
        $data = $data = Periodo::where('estado', 'activo')
            ->with(['users' => function($query) use ($user_id)  {
                $query->where('user_id', $user_id);
            }])
        ->first();
        return $data;
    }
}
