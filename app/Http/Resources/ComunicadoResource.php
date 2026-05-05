<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComunicadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'titulo'=>$this->titulo,
            'descripcion'=>$this->descripcion,
            'imagen'=>$this->imagen,
            'tipo'=>$this->tipo,
            'estado'=>$this->estado,
            'audiencia'=>$this->audiencia,
            'fechaInicio'=>$this->fecha_inicio,
            'fechaFin'=>$this->fecha_fin,
            'usuarios' => $this->whenLoaded('usuarios', function () {
                return $this->usuarios->pluck('id')->values();
            }),
        ];
    }
}
