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
        Schema::create('proyecto_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->string('codigo');
            $table->float('inicial', 15,2);
            $table->float('definitivo', 15,2)->default(0);
            $table->float('disponibilidad', 15,2)->default(0);
            $table->float('registros', 15,2)->default(0);
            $table->float('pagos')->default(0);
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
        Schema::dropIfExists('proyecto_presupuestos');
    }
};
