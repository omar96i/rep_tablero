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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('hecho_id');
            $table->unsignedBigInteger('politica_id');
            // $table->unsignedBigInteger('estrategia_id');
            $table->unsignedBigInteger('programa_id');
            $table->year('vigencia');
            $table->string('nombre');
            $table->timestamps();
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('hecho_id')->references('id')->on('hechos');
            $table->foreign('politica_id')->references('id')->on('politicas');
            // $table->foreign('estrategia_id')->references('id')->on('estrategias');
            $table->foreign('programa_id')->references('id')->on('programas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
};
