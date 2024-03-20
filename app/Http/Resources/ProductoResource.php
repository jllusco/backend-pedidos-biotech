<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'rutaImagen'=>$this->ruta_imagen,
            'cantidadActual'=>$this->cantidad_actual,
            'precioUnitario'=>$this->precio_unitario,
            'estado'=>$this->estado,
            'categoriaId'=>$this->categoria_id,
            'categoria'=> new CategoriaResource($this->whenLoaded('categoria'))
        ];
    }
}
