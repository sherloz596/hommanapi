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
        Schema::create('tareas', function (Blueprint $table) {
            $table->increments('cod_tarea');
            $table->string('tarea');
            $table->unsignedbigInteger('cod_usuario');
            $table->string('frecuencia');
            $table->string('ultimo_realizado');
            $table->timestamps();
            
            $table->foreign('cod_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
