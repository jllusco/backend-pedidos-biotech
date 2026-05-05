<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicado extends BaseModel
{
     use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'comunicado';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'imagen',
        'documento',
        'tipo',
        'estado',
        'audiencia',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'comunicado_usuario',
            'comunicado_id',
            'usuario_id'
        );
    }

}
