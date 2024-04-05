<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 10:06
 */

namespace App\Http\Resources\Biotech;


use App\Http\Resources\BaseResourceCollection;

class ProveedorCollection extends  BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, ProveedorResource::class);
    }
}