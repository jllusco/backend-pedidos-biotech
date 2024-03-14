<?php

namespace App\Http\Resources;
class PermisoCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, PermisoResource::class);
    }
}
