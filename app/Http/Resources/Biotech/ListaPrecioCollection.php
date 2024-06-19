<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 18/3/2024
 * Time: 16:02
 */

namespace App\Http\Resources\Biotech;

use App\Http\Resources\UserSimpleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListaPrecioCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [

            'rows' => $this->collection->map(function ($pedido) {
                return [
                    'id'=>$pedido->id,
                    'nombre'=>$pedido->nombre,
                    'estado'=>$pedido->estado,
                    'totalProductos'=>$pedido->total_productos,
                    'createdAt'=>$pedido->created_at
                ];
            }),
            'pagination' => [
                'total'       => $this->total(),
                'count'       => $this->count(),
                'perPages'     => $this->perPage(),
                'currentPage' => $this->currentPage(),
                'totalPages'  => $this->lastPage(),
            ],
        ];
    }
}