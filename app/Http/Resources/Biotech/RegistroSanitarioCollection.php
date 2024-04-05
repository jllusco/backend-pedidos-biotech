<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 16:15
 */

namespace App\Http\Resources\Biotech;


use App\Http\Resources\BaseResourceCollection;
use App\Http\Resources\RegistroSanitarioResource;

class RegistroSanitarioCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource, RegistroSanitarioResource::class);
    }
}