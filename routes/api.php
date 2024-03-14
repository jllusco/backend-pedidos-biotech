<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'auth'],function(){
    Route::controller(AuthController::class)->group(function (){
        Route::post('login','login');
    });
});

Route::group([
    'prefix'=>'system',
    'middleware'=>'auth:sanctum'
],function(){
    Route::controller(ParametroController::class)->group(function (){
        Route::get('parametros','index');
        Route::post('parametros','store');
        Route::get('parametros/{parametro}','show');
        Route::put('parametros/{parametro}','update');
        Route::delete('parametros/{parametro}','destroy');
    });

    Route::controller(UsuarioController::class)->group(function (){
        Route::get('usuarios','index');
        Route::get('usuarios/{user}','show');
        Route::post('usuarios','store');
    });

    Route::controller(RolController::class)->group(function (){
        Route::get('roles','index');
        Route::post('roles','store');
        Route::get('roles/{rol}','show');
        Route::put('roles/{rol}','update');
        Route::get('roles/{rol}/permisos','permisos');
    });

    Route::controller(MenuController::class)->group(function (){
        Route::get('menus','index');
        Route::post('menus','store');
        Route::get('menus/{menu}','show');
    });

    Route::controller(PermisoController::class)->group(function (){
        Route::get('permisos','index');
        Route::post('permisos','store');
    });

   
});

Route::group([
    'prefix'=>'biotech',
    'middleware'=>'auth:sanctum'
],function(){
    Route::controller(CategoriaController::class)->group(function (){
        Route::get('categorias','index');
        Route::post('categorias','store');
    });

    Route::controller(ProductoController::class)->group(function (){
        Route::get('productos','index');
        Route::post('productos','store');
    });
});







