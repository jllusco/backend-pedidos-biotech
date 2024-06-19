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

class ListaPrecioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'nombre'=>$this->nombre,
            'estado'=>$this->estado,
            'createdBy'=>$this->created_by,
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at
        ];
    }


    public function addAttributes($key,$value,Request $request){
        $attributes = parent::toArray($request);
        $attributes[$key] = $value;
        return $attributes;
    }
}