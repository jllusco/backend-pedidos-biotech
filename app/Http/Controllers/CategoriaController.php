<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;

class CategoriaController extends Controller
{
    public function index(){
        try {
            $menus = Categoria::paginate();
            return ApiResponse::success( new CategoriaCollection($menus));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreCategoriaRequest $request){
        try {
            $datos = $request->all();
            $usuario = new CategoriaResource(Categoria::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
