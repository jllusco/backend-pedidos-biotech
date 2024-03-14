<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametro extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'parametro';

    protected $fillable = [
        'id',
        'grupo',
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'sistema'
    ];
}
