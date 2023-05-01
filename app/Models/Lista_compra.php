<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista_compra extends Model
{
    use HasFactory;

    protected $table = 'lista_compras';
    protected $primaryKey = 'cod_lista';
    protected $fillable = ['cod_usuario','nombre','estado'];
}
