<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'pedido';

    protected $fillable = [
        'id',
        'codigo',
        'usuario_solicitante_id',
        'fecha',
        'monto_total',
        'fecha_entrega',
        'usuario_entrega_id',
        'estado',
        'tipo',
        'sub_tipo',
        'metodo_pago',
        'ciudad',
        'institucion',
        'asunto',
        'comentario',
        'contacto'
    ];

}
