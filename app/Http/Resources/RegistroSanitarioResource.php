<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistroSanitarioResource extends JsonResource
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
            'numero'=>$this->numero,
            'fechaEmision'=>$this->fecha_emision,
            'fechaVencimiento'=>$this->fecha_vencimiento,
            'estado'=>$this->estado,
            'rutaDocumento'=>$this->ruta_documento,
            'totalProductos'=>$this->total_productos
        ];
    }
}
