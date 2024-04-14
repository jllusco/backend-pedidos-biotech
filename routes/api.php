<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RegistroSanitarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PedidoProveedorController;

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

Route::group(['prefix'=>'publico'],function(){
    Route::controller(PedidoController::class)->group(function (){
        Route::get('codigo','generarCodigo');
        Route::get('pdf/{pedido}','generarPdf');
        Route::get('pedidos/{pedido}/excel','generarPdfOpa');
        Route::post('pedidos/pial','generarPial');
    });
});

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
        Route::patch('usuarios/{user}/estado','updateEstado');
        Route::patch('usuarios/contrasena','updateContrasena');
        Route::patch('usuarios/{user}/reset-contrasena','restorePassword');
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

    Route::controller(ProveedorController::class)->group(function (){
        Route::get('proveedores','index');
        Route::post('proveedores','store');
    });

    Route::controller(RegistroSanitarioController::class)->group(function (){
        Route::get('registros-sanitarios','index');
        Route::post('registros-sanitarios','store');
    });

    Route::controller(ProductoController::class)->group(function (){
        Route::get('productos','index');
        Route::get('productos/{producto}','show');
        Route::post('productos','store');
        Route::put('productos/{producto}','update');
        Route::patch('productos/{producto}/imagen','updateImagen');
        Route::patch('productos/{producto}/estado','updateEstado');
    });

    Route::controller(PedidoController::class)->group(function (){
        Route::get('pedidos','index');
        Route::post('pedidos','store');
        Route::get('pedidos/{pedido}','show');
        Route::put('pedidos/{pedido}/enviar','enviar');
        Route::put('pedidos/{pedido}/atencion','recepcionar');
        Route::get('pedidos/{pedido}/pdf','generarPdf');
        Route::get('pedidos/{pedido}/excel-opa','generarPdfOpa');
    });

    Route::controller(PedidoProveedorController::class)->group(function(){
        Route::get('pial','index');
        Route::post('pial','store');
        Route::get('pial/{pedidoProveedor}','show');
        Route::get('pial/{pedidoProveedor}/pdf','generarPdf');
        Route::get('pial/{pedidoProveedor}/excel','generarExcel');
    });
});


Route::group([
    'prefix'=>'reporte',
    'middleware'=>'auth:sanctum'
],function(){
    Route::controller(PedidoController::class)->group(function (){
        Route::get('pedidos/cantidad','cantidades');
    });
});









