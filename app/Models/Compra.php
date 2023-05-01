<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $primaryKey = 'cod_linea';
    protected $fillable = ['cod_lista','cod_producto','cod_usuario','nombre','estado_producto'];
}
