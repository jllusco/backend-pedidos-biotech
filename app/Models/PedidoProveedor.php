<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProveedor extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'pedido_proveedor';

    protected $fillable = [
        'id',
        'codigo',
        'usuario_solicitante_id',
        'nombre_usuario_solicitante',
        'fecha',
        'monto_total',
        'estado',
        'tipo',
        'moneda',
        'asunto',
        'comentario',
        'proveedor_id'
    ];

    public function solicitante(){
        return $this->belongsTo(User::class,'usuario_solicitante_id');
    }
}
