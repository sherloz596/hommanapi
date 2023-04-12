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
        Schema::create('lista_compras', function (Blueprint $table) {
            $table->increments('cod_lista');
            $table->unsignedbigInteger('cod_usuario');
            $table->unsignedInteger('cod_producto');
            $table->string('nombre',20);
            $table->timestamps();

            $table->unique(['nombre', 'cod_usuario']);
            $table->foreign('cod_usuario')->references('id')->on('users');
            $table->foreign('cod_producto')->references('cod_producto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_compras');
    }
};
