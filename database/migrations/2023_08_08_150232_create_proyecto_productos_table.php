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
        Schema::create('proyecto_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('dependencia_id');
            $table->unsignedBigInteger('meta_producto_id');
            $table->float('porcentaje_definitivo', 15,2)->default(0);
            $table->float('porcentaje_disponibilidad', 15,2)->default(0);
            $table->float('porcentaje_registros', 15,2)->default(0);
            $table->float('porcentaje_pagos', 15,2)->default(0);
            $table->float('valor_definitivo', 15,2)->default(0);
            $table->float('valor_disponibilidad', 15,2)->default(0);
            $table->float('valor_registros', 15,2)->default(0);
            $table->float('valor_pagos', 15,2)->default(0);
            $table->float('porcentaje_evaluacion', 15,2)->default(0);
            $table->timestamps();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->foreign('dependencia_id')->references('id')->on('dependencias');
            $table->foreign('meta_producto_id')->references('id')->on('meta_de_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyecto_productos');
    }
};
