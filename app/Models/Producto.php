<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'producto';

    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'descripcion',
        'ruta_imagen',
        'precio_unitario',
        'estado'
    ];
}
