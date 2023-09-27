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
            $table->float('porcentaje_definitivo')->default(0);
            $table->float('porcentaje_disponibilidad')->default(0);
            $table->float('porcentaje_registros')->default(0);
            $table->float('porcentaje_pagos')->default(0);
            $table->float('valor_definitivo')->default(0);
            $table->float('valor_disponibilidad')->default(0);
            $table->float('valor_registros')->default(0);
            $table->float('valor_pagos')->default(0);
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
        Schema::dropIfExists('proyecto_productos');
    }
};
