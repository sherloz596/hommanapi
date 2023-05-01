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
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('cod_linea');
            $table->unsignedInteger('cod_lista');
            $table->unsignedbigInteger('cod_usuario');
            $table->unsignedInteger('cod_producto');
            $table->string('nombre',20);
            $table->string('estado_producto',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
