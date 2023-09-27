<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoMovimientoFinanciero extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_presupuesto_id',
        'valor',
        'tipo_movimiento',
        'acta_aprovacion'
    ];

    public function presupuesto(){
        return $this->belongsTo(ProyectoPresupuesto::class);
    }

    public static function TotalMovimientos($presupuesto_id){
        $presupuesto_definitivo = 0;
        $movimientos = ProyectoMovimientoFinanciero::where('proyecto_presupuesto_id', $presupuesto_id)->get();

        foreach ($movimientos as $movimiento) {
            if ($movimiento->tipo_movimiento == 'adicion' || $movimiento->tipo_movimiento == 'creditos' || $movimiento->tipo_movimiento == 'inicial') {
                $presupuesto_definitivo += $movimiento->valor;
            }elseif($movimiento->tipo_movimiento == 'reduccion' || $movimiento->tipo_movimiento == 'contracreditos'){
                $presupuesto_definitivo -= $movimiento->valor;
            }
        }

        return $presupuesto_definitivo;
    }
}
