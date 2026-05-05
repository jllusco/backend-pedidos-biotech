<?php

namespace App\Http\Resources;

class ComunicadoCollection extends  BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, ComunicadoResource::class);
    }
}
