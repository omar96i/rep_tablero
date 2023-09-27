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
        Schema::create('meta_de_producto_reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meta_producto_id');
            $table->string('meta_año');
            $table->date('fecha_reporte');
            $table->float('meta_alcanzada');
            $table->text('actividad');
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
        Schema::dropIfExists('meta_de_producto_reportes');
    }
};
