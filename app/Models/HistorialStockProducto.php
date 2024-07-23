<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialStockProducto extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'historial_stock_producto';

    protected  $fillable = [
      'id',
      'producto_id',
      'tipo',
      'cantidad',
      'saldo',
      'descripcion',
      'detalle_pedido_id',
      'created_at'
    ];

    public function detallePedido()
    {
        return $this->hasOne(DetallePedido::class,'');
    }

}
