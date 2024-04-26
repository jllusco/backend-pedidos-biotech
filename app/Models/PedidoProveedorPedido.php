<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/4/2024
 * Time: 14:12
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoProveedorPedido extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'pedido_proveedor_pedido';

    protected $fillable = [
        'id',
        'pedido_id',
        'pedido_proveedor_id'
    ];

}