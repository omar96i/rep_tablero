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
        Schema::create('meta_de_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->unsignedBigInteger('hecho_id')->nullable();
            $table->unsignedBigInteger('politica_id')->nullable();
            $table->unsignedBigInteger('estrategia_id')->nullable();
            $table->unsignedBigInteger('programa_id')->nullable();
            $table->unsignedBigInteger('indicador_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('codigo')->nullable();
            $table->text('nombre')->nullable();
            $table->string('indicador_meta')->nullable();
            $table->string('siglas_indicador')->nullable();
            $table->string('peso')->nullable();
            $table->string('linea_base')->nullable();
            $table->string('year')->nullable();
            $table->float('meta_year_1')->nullable();
            $table->float('meta_year_2')->nullable();
            $table->float('meta_year_3')->nullable();
            $table->float('meta_year_4')->nullable();
            $table->float('meta_cuatrienio')->nullable();
            $table->float('recurso_year_1')->nullable();
            $table->float('recurso_year_2')->nullable();
            $table->float('recurso_year_3')->nullable();
            $table->float('recurso_year_4')->nullable();
            $table->float('recurso_cuatrienio')->nullable();
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
        Schema::dropIfExists('meta_de_productos');
    }
};
