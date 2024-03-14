<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 08:52
 */

namespace App\Http\Resources;


class MenuCollection extends  BaseResourceCollection
{

    public function __construct($resource)
    {
        parent::__construct($resource, MenuResource::class);
    }

}