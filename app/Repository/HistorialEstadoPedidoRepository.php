<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;

use App\Models\HistorialEstadoPedido;

class HistorialEstadoPedidoRepository
{
    public function getByPedido($idPedido){
        $query = HistorialEstadoPedido::query();
        $query->where('pedido_id','=',$idPedido);
        $query->orderBy('created_at','DESC');
        return $query->get();
    }
}