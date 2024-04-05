<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\ProveedorCollection;
use App\Http\Resources\Biotech\ProveedorResource;
use App\Models\Proveedor;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;

class ProveedorController extends Controller
{
    public function index(){
        try {
            $menus = Proveedor::paginate();
            return ApiResponse::success( new ProveedorCollection($menus));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreProveedorRequest $request){
        try {
            $datos = $request->all();
            $datos['contacto'] = json_encode($datos['contacto']);
            $usuario = new ProveedorResource(Proveedor::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
