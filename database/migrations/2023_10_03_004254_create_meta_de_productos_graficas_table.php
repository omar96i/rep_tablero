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
        Schema::create('meta_de_productos_graficas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meta_producto_id');
            $table->year('year');
            $table->float('meta_programada')->nullable()->default(0);
            $table->float('meta_alcanzada')->nullable()->default(0);
            $table->float('porcentaje_avance')->nullable()->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('meta_de_productos_graficas');
    }
};
