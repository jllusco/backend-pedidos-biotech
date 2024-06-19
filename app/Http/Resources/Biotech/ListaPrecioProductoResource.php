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

class ListaPrecioProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'listaPrecioId'=>$this->lista_precio_id,
            'productoId'=>$this->producto_id,
            //'precioUnitario'=>round(floatval($this->precio_unitario),2),
            'precioUnitario'=>$this->precio_unitario,
            'producto'=> new ProductoResource($this->whenLoaded('producto')),
        ];
    }
}