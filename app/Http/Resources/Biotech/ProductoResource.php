<?php

namespace App\Http\Resources\Biotech;

use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ParametroResource;
use App\Http\Resources\RegistroSanitarioResource;
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
            'precioExwork'=>$this->precio_exwork,
            'estado'=>$this->estado,
            'temperatura'=>$this->temperatura,
            'unidad'=>$this->unidad,
            'oferta'=>$this->oferta,
            'tipo'=>$this->tipo,
            'rutaEspecificacionTecnica'=>$this->ruta_especificacion_tecnica,
            'presentacionId'=>$this->presentacion_id,
            'presentacion'=> new ParametroResource($this->whenLoaded('presentacion')),
            'registroSanitarioId'=>$this->presenteacion_id,
            'registroSanitario'=> new RegistroSanitarioResource($this->whenLoaded('registroSanitario')),
            'categoriaId'=>$this->categoria_id,
            'categoria'=> new CategoriaResource($this->whenLoaded('categoria')),
            'proveedorId'=>$this->proveedor_id,
            'proveedor'=> new ProveedorResource($this->whenLoaded('proveedor'))
        ];
    }
}
