<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/3/2024
 * Time: 16:02
 */

namespace App\Http\Resources\Biotech;

use App\Http\Resources\UserSimpleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PedidoCollection extends ResourceCollection
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
                    'fecha'=>$pedido->fecha,
                    'montoTotal'=>$pedido->monto_total,
                    'fechaEntrega'=>$pedido->fecha_enterga,
                    'usuarioEntregaId'=>$pedido->usuario_entrega_id,
                    'nombreUsuarioEntrega'=>$pedido->nombre_usuario_entrega,
                    'estado'=>$pedido->estado,
                    'tipo'=>$pedido->tipo,
                    'subTipo'=>$pedido->sub_tipo,
                    'institucion'=>$pedido->institucion,
                    'metodoPago'=>$pedido->metodo_pago,
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