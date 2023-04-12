<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacenaje extends Model
{
    use HasFactory;

    protected $table = 'almacenajes';
    protected $primaryKey = 'cod_almacenaje';
    protected $fillable = ['cod_usuario','cod_producto','cod_despensa','cod_unidad','cantidad','fec_almac'];
}
