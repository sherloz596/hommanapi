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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('cod_producto');
            $table->string('producto',30);
            $table->unsignedbigInteger('cod_usuario');
            $table->integer('comprar');
            $table->integer('favorito');
            $table->string('idioma',3);
            $table->timestamps();
            
            $table->unique(['producto', 'cod_usuario']);
            $table->foreign('cod_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
