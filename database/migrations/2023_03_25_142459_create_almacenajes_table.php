<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('almacenajes', function (Blueprint $table) {
            $table->increments('cod_almacenaje');
            $table->unsignedbigInteger('cod_usuario');
            $table->unsignedInteger('cod_producto');
            $table->unsignedInteger('cod_despensa');
            $table->unsignedInteger('cod_unidad');
            $table->integer('cantidad');
            $table->date('fec_almac');
            $table->timestamps();
            
            $table->foreign('cod_producto')->references('cod_producto')->on('productos');
            $table->foreign('cod_despensa')->references('cod_despensa')->on('despensas');
            $table->foreign('cod_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacenajes');
    }
};
