<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 11:52
 */

namespace App\Http\Resources;


class ParametroCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, ParametroResource::class);
    }
}