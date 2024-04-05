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

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'codigo'=>$this->codigo,
            'usuarioSolicitanteId'=>$this->usuario_solicitante_id,
            'fecha'=>$this->fecha,
            'montoTotal'=>$this->monto_total,
            'fechaEntrega'=>$this->fecha_enterga,
            'usuarioEntregaId'=>$this->usuario_entrega_id,
            'estado'=>$this->estado,
            'tipo'=>$this->tipo,
            'subTipo'=>$this->sub_tipo,
            'metodoPago'=>$this->metodo_pago,
            'createdAt'=>$this->created_at,
            'ciudad'=>$this->ciudad,
            'institucion'=>$this->institucion,
            'asunto'=>$this->asunto,
            'comentatio'=>$this->comentatio,
            'contacto'=>$this->contacto,
            'createdBy'=>$this->created_by
        ];
    }


    public function addAttributes($key,$value,Request $request){
        $attributes = parent::toArray($request);
        $attributes[$key] = $value;
        return $attributes;
    }
}