<?php

namespace App\Http\Resources\Biotech;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CronogramaResource extends JsonResource
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
            'mes'=>$this->mes,
            'nombre'=>$this->nombre,
            'inicio'=>$this->inicio,
            'fin'=>$this->fin,
            'estado'=>$this->estado
        ];
    }
}
