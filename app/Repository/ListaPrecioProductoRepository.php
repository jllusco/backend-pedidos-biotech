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
        $query = ListaPrecioProducto::with('producto.registroSanitario');
        $query->where('lista_precio_id','=',$idListaPrecio);
        $query->orderBy('created_at','DESC');

        $resultados = $query->get();

        $resultados = $resultados->sortBy(function($item) {
            return $item->producto->nombre;
        });
        return $resultados->values()->all();
    }

    public function getProductosVigentes($idListaPrecio,$idProductos){
        $query = ListaPrecioProducto::select('producto_id','precio_unitario')
            ->where('lista_precio_id','=',$idListaPrecio)
            ->whereIn('producto_id',$idProductos)
            ->whereNull('deleted_at');
        return $query->get()->pluck('precio_unitario', 'producto_id')
            ->toArray();
    }
}