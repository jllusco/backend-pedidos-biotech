<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;


use App\Models\DetallePedido;

class DetallePedidoRepository
{
    public function getByPedido($idPedido){
        $query = DetallePedido::with('producto');
        $query->where('pedido_id','=',$idPedido);
        $query->orderBy('created_at','DESC');
        return $query->get();
    }

    public function getByPedidosPial($idPedidos){
        $query = DetallePedido::query();
        $query->selectRaw('producto_id, producto.precio_exwork, producto.tipo, SUM(cantidad) as cantidad')
            ->join('producto', 'producto.id', '=', 'producto_id')
            ->groupBy('producto_id');
        return $query->get();
    }
}