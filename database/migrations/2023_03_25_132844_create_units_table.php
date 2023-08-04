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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('cod_unidad');
            $table->string('unidad',20);
            $table->string('abreviatura',5);
            $table->unsignedbigInteger('cod_usuario');
            $table->string('idioma',20);
            $table->timestamps();
            
            $table->unique(['unidad', 'cod_usuario']);
            $table->foreign('cod_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
