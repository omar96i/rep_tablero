<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    use HasFactory;

    protected $table = 'indicadores';

    protected $fillable = [
        'nombre',
    ];

    public function meta_productos(){
        return $this->hasMany(MetaDeProducto::class, 'indicador_id');
    }
}
