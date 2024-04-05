<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 1/3/2024
 * Time: 11:21
 */

namespace App\Http\Resources\Biotech;

use App\Http\Resources\BaseResourceCollection;

class ProductoCollection extends  BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, ProductoResource::class);
    }
}