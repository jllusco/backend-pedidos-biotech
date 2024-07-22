<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'detalle_pedido';

    protected $fillable = [
        'id',
        'pedido_id',
        'producto_id',
        'tipo_producto',
        'cantidad',
        'cantidad_entrega_inmediata',
        'estado',
        'precio',
        'monto',
        'historial_stock_producto_id'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function historialStockProducto(){
        return $this->belongsTo(HistorialStockProducto::class,'historial_stock_producto_id');
    }
}
