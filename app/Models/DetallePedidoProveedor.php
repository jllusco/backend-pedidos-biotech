<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedidoProveedor extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'detalle_pedido_proveedor';

    protected $fillable = [
        'id',
        'pedido_proveedor_id',
        'producto_id',
        'cantidad',
        'tipo_producto',
        'precio',
        'monto'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
