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
        Schema::create('lista_compra_lins', function (Blueprint $table) {
            $table->increments('cod_linea');
            $table->unsignedInteger('cod_lista');
            $table->unsignedbigInteger('cod_usuario');
            $table->unsignedInteger('cod_producto');
            $table->string('nombre',20);
            $table->string('estado_producto',20);
            $table->timestamps();

            //$table->unique(['cod_lista', 'linea']);
            $table->foreign('cod_lista')->references('cod_lista')->on('lista_compras');
            $table->foreign('cod_usuario')->references('id')->on('users');
            $table->foreign('cod_producto')->references('cod_producto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_compra_lins');
    }
};
