<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $primaryKey = 'cod_tarea';
    protected $fillable = ['tarea','cod_usuario','frecuencia','ultimo_realizado'];
}
