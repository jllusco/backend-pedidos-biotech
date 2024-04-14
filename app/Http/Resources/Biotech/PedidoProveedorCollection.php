<?php

namespace App\Http\Resources\Biotech;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PedidoProveedorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [

            'rows' => $this->collection->map(function ($pedido) {
                return [
                    'id'=>$pedido->id,
                    'codigo'=>$pedido->codigo,
                    'usuarioSolicitanteId'=>$pedido->usuario_solicitante_id,
                    'nombreUsuarioSolicitante'=>$pedido->nombre_usuario_solicitante,
                    'tipo'=>$pedido->tipo,
                    'fecha'=>$pedido->fecha,
                    'montoTotal'=>$pedido->monto_total,
                    'asunto'=>$pedido->asunto,
                    'comentario'=>$pedido->comentario,
                    'moneda'=>$pedido->moneda,
                    'totalProductos'=>$pedido->total_productos,
                    'createdAt'=>$pedido->created_at
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