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
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id');
            $table->unsignedBigInteger('hecho_id');
            $table->unsignedBigInteger('politica_id');
            $table->unsignedBigInteger('estrategia_id')->nullable();
            $table->string('nombre');
            $table->string('peso');
            $table->text('descripcion');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('hecho_id')->references('id')->on('hechos');
            $table->foreign('politica_id')->references('id')->on('politicas');
            $table->foreign('estrategia_id')->references('id')->on('estrategias');
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
        Schema::dropIfExists('programas');
    }
};
