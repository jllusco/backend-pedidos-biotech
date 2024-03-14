<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoCollection;
use App\Http\Resources\ProductoResource;

class ProductoController extends Controller
{
    public function index(){
        try {
            $menus = Producto::paginate();
            return ApiResponse::success( new ProductoCollection($menus));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreProductoRequest $request){
        try {
            $datos = $request->all();
            $usuario = new ProductoResource(Producto::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
