<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/3/2024
 * Time: 16:01
 */
namespace App\Http\Resources\Biotech;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoProveedorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'codigo'=>$this->codigo,
            'usuarioSolicitanteId'=>$this->usuario_solicitante_id,
            'fecha'=>$this->fecha,
            'montoTotal'=>$this->monto_total,
            'tipo'=>$this->tipo,
            'createdAt'=>$this->created_at,
            'asunto'=>$this->asunto,
            'comentatio'=>$this->comentatio,
            'createdBy'=>$this->created_by
        ];
    }

}