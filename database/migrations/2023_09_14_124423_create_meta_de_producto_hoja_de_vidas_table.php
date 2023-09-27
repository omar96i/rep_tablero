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
        Schema::create('meta_de_producto_hoja_de_vidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meta_producto_id');
            $table->string('linea_base')->nullable();
            $table->string('periocidad')->nullable();
            $table->string('fuente')->nullable();
            $table->string('periodo_fuente')->nullable();
            $table->string('localizacion')->nullable();
            $table->string('poblacion')->nullable();
            $table->text('definiciones')->nullable();
            $table->string('valoracion')->nullable();
            $table->string('medicion')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('formula')->nullable();
            $table->string('variables')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('meta_de_producto_hoja_de_vidas');
    }
};
