<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/3/2024
 * Time: 16:01
 */
namespace App\Http\Resources\Biotech;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
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
            'estado'=>$this->estado
        ];
    }
}