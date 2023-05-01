<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despensa extends Model
{
    use HasFactory;

    protected $table = 'despensas';
    protected $primaryKey = 'cod_despensa';
    protected $fillable = ['despensa','cod_usuario','idioma'];
}
