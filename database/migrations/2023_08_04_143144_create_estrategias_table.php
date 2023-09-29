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
        Schema::create('estrategias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->unsignedBigInteger('hecho_id')->nullable();
            $table->unsignedBigInteger('politica_id')->nullable();
            $table->text('nombre')->nullable();
            $table->string('peso')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->foreign('hecho_id')->references('id')->on('hechos');
            $table->foreign('politica_id')->references('id')->on('politicas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estrategias');
    }
};
