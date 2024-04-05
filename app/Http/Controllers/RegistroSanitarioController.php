<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\RegistroSanitarioCollection;
use App\Http\Resources\RegistroSanitarioResource;
use App\Models\RegistroSanitario;
use App\Http\Requests\StoreRegistroSanitarioRequest;
use App\Http\Requests\UpdateRegistroSanitarioRequest;

class RegistroSanitarioController extends Controller
{
    public function index(){
        try {
            $registros = RegistroSanitario::paginate();
            return ApiResponse::success( new RegistroSanitarioCollection($registros));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreRegistroSanitarioRequest $request){
        try {
            $datos = $request->all();
            $registro = new RegistroSanitarioResource(RegistroSanitario::create($datos));
            return ApiResponse::success($registro);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
