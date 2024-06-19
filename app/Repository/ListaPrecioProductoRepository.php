<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;

use App\Models\ListaPrecioProducto;

class ListaPrecioProductoRepository
{
    public function getByListaPrecio($idListaPrecio){
        $query = ListaPrecioProducto::with('producto');
        $query->where('lista_precio_id','=',$idListaPrecio);
        $query->orderBy('created_at','DESC');

        $resultados = $query->get();

        $resultados = $resultados->sortBy(function($item) {
            return $item->producto->nombre;
        });

        return $resultados->values()->all();
    }
}