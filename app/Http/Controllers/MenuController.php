<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    public function index(){
        try {
            $menus = Menu::paginate();
            return ApiResponse::success( new MenuCollection($menus));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreMenuRequest $request){
        try {
            $datos = $request->all();
            $usuario = new MenuResource(Menu::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(Menu $menu)
    {
        try {
            return ApiResponse::success(new MenuResource($menu));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
