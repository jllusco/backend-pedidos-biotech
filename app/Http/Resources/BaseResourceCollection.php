<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 09:34
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    protected $resourceClass;

    public function __construct($resource, $resourceClass)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
    }

    public function toArray($request)
    {
        return [
            'rows' => $this->resourceClass ::collection($this->collection),
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