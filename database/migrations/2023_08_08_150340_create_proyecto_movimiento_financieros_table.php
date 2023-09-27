<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_movimiento_financieros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_presupuesto_id');
            $table->enum('tipo_movimiento', ['inicial', 'adicion', 'reduccion', 'creditos', 'contracreditos']);
            $table->float('valor');
            $table->string('acta_aprovacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_movimiento_financieros');
    }
};
