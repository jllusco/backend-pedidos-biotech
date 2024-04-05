<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 19:16
 */

namespace App\Http\Resources\Biotech;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetallePedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'pedidoId'=>$this->pedido_id,
            'productoId'=>$this->producto_id,
            'cantidad'=>$this->cantidad,
            'precio'=>$this->precio,
            'monto'=>$this->monto,
            'producto'=> new ProductoResource($this->whenLoaded('producto')),
        ];
    }
}