<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista_compra_lin extends Model
{
    use HasFactory;

    protected $table = 'lista_compra_lins';
    protected $primaryKey = 'cod_linea';
    protected $fillable = ['cod_lista','cod_producto','cod_usuario','estado_producto'];
}
