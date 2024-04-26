<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/3/2024
 * Time: 16:02
 */

namespace App\Http\Resources\Biotech;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistorialEstadoPedidoCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'pedidoId'=>$this->pedido_id,
            'estado'=>$this->estado,
            'nombreUsuario'=>$this->nombre_usuario,
            'rolUsuario'=>$this->rol_usuario,
            'createdAt'=>$this->created_at
        ];
    }
}