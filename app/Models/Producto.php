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
        'precio_exwork',
        'estado',
        'unidad',
        'temperatura',
        'registro_sanitario_id',
        'presentacion_id',
        'categoria_id',
        'proveedor_id',
        'oferta',
        'tipo'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function presentacion()
    {
        return $this->belongsTo(Parametro::class);
    }

    public function registroSanitario()
    {
        return $this->belongsTo(RegistroSanitario::class);
    }

    public function getTemperaturaAttribute($value)
    {
        return json_decode($value);
    }
}
