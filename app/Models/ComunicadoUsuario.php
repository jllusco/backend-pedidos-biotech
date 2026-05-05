<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComunicadoUsuario extends Model
{
    protected $table = 'comunicado_usuario';

    public $timestamps = false;

    protected $fillable = [
        'comunicado_id',
        'usuario_id'
    ];
}
