<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 19:16
 */

namespace App\Http\Resources\Biotech;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetallePedidoCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return DetallePedidoResource::collection($this->collection);
    }
}