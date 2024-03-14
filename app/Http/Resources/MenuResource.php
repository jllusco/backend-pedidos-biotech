<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 08:50
 */

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{

    use SoftDeletes;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'nombre'=>$this->nombre,
            'ruta'=>$this->ruta,
            'icono'=>$this->icono,
            'orden'=>$this->orden,
            'estado'=>$this->estado
        ];
    }
}


