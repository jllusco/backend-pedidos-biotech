<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 08:50
 */

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'usuario'=>$this->name,
            'tipoDocumento'=>$this->tipo_documento,
            'numeroDocumento'=>$this->numero_documento,
            'nombres'=>$this->nombres,
            'primerApellido'=>$this->primer_apellido,
            'segundoApellido'=>$this->segundo_apellido,
            'correoElectronico'=>$this->correo_electronico,
            'celular'=>$this->celular,
            'estado'=>$this->estado,
            'departamento'=>$this->departamento,
            'institucion'=>$this->institucion,
            'rolId'=>$this->rol_id,
            'rol'=> new RolResource($this->whenLoaded('rol'))
        ];
    }
}


