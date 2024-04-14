<?php

namespace App\Repository;

use App\Models\DetallePedidoProveedor;

class DetallePedidoProveedorRepository
{
    public function getByPedido($idPedido){
        $query = DetallePedidoProveedor::with('producto');
        $query->where('pedido_proveedor_id','=',$idPedido);
        $query->orderBy('created_at','DESC');
        return $query->get();
    }
}