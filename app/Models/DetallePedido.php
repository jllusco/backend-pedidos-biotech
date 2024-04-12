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
        'tipo',
        'cantidad',
        'precio',
        'monto'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
