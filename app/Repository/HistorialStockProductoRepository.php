<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;

use App\Models\HistorialEstadoPedido;
use App\Models\HistorialStockProducto;

class HistorialStockProductoRepository
{
    public function findAll($request){

        $query = HistorialStockProducto::query();

        if(isset($request['idProducto'])){
            $query->where('producto_id','=',$request['idProducto']);
        }

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }
}