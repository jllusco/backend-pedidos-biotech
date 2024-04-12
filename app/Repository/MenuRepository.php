<?php
namespace  App\Repository;

//use App\Http\Resources\MenuCollection;

use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;

class MenuRepository{

    public function obtenerMenusPorRol($rolId){
        $menus = Menu::rightJoin('rol_menu', 'menu.id', '=', 'rol_menu.menu_id')
        ->whereNull('rol_menu.deleted_at')
        ->where('rol_menu.rol_id', $rolId)
        ->select('menu.*')
        ->orderBy('menu.orden','ASC')
        ->get();
        return MenuResource::collection($menus);
    }
}