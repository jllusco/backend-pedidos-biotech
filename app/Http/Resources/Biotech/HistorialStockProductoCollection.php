<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 22/7/2024
 * Time: 21:05
 */

namespace App\Http\Resources\Biotech;


use Illuminate\Http\Resources\Json\ResourceCollection;

class HistorialStockProductoCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'rows' => $this->collection->map(function ($historialStockProducto) {
                return [
                    'id'=>$historialStockProducto->id,
                    'productoId'=>$historialStockProducto->producto_id,
                    'tipo'=>$historialStockProducto->tipo,
                    'cantidad'=>$historialStockProducto->cantidad,
                    'saldo'=>$historialStockProducto->saldo,
                    'descripcion'=>$historialStockProducto->descripcion,
                    'detallePedidoId'=>$historialStockProducto->detalle_pedido_id,
                    'fechaCreacion'=>$historialStockProducto->created_at,

                ];
            }),
            'pagination' => [
                'total'       => $this->total(),
                'count'       => $this->count(),
                'perPages'     => $this->perPage(),
                'currentPage' => $this->currentPage(),
                'totalPages'  => $this->lastPage(),
            ],
        ];
    }

}