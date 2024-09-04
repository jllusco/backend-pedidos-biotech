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
    public function getByListaPrecio($idListaPrecio)
    {
        $query = ListaPrecioProducto::with(['producto.registroSanitario', 'producto.categoria']);
        $query->where('lista_precio_id', '=', $idListaPrecio)
            ->join('producto', 'lista_precio_producto.producto_id', '=', 'producto.id')
            ->orderBy('producto.nombre', 'ASC');

        $resultados = $query->get();

        return $resultados->values()->all();
    }

    public function getProductosVigentes($idListaPrecio, $idProductos)
    {
        $query = ListaPrecioProducto::select('producto_id', 'precio_unitario')
            ->where('lista_precio_id', '=', $idListaPrecio)
            ->whereIn('producto_id', $idProductos)
            ->whereNull('deleted_at');
        return $query->get()->pluck('precio_unitario', 'producto_id')
            ->toArray();
    }
}