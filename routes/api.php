<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\ListaPrecioController;
use App\Http\Controllers\ListaPrecioProductoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PedidoProveedorController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RegistroSanitarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;

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

Route::get('status', function () {
    return response()->json([
        'mensaje'=>'Servicio api biotech funcionando correctamente',
        'fecha_actual' => \Carbon\Carbon::now(),
        'version'=>'1.0.0'
    ]);
});

Route::group(['prefix'=>'publico'],function(){
    /*Route::controller(PedidoController::class)->group(function (){
        Route::get('codigo','generarCodigo');
        Route::get('pdf/{pedido}','generarPdf');
        Route::get('pedidos/{pedido}/excel','generarPdfOpa');
        Route::post('pedidos/pial','generarPial');
    });*/
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
        Route::get('parametros/grupos','grupos');
        Route::post('parametros','store');
        Route::get('parametros/{parametro}','show');
        Route::put('parametros/{parametro}','update');
        Route::delete('parametros/{parametro}','destroy');
    });

    Route::controller(UsuarioController::class)->group(function (){
        Route::get('usuarios','index');
        Route::get('usuarios/{user}','show');
        Route::put('usuarios/{user}','update');
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
    Route::controller(CronogramaController::class)->group(function (){
        Route::get('cronogramas','index');
        Route::put('cronogramas/{cronograma}','update');
    });

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
        Route::get('registros-sanitarios/{registroSanitario}','show');
        Route::put('registros-sanitarios/{registroSanitario}','update');
        Route::patch('registros-sanitarios/{registroSanitario}/documento','updateDocumento');
    });

    Route::controller(ProductoController::class)->group(function (){
        Route::get('productos','index');
        Route::get('productos/cantidades-tipo','getCantidadesTipo');
        Route::get('productos/{producto}','show');
        Route::post('productos','store');
        Route::put('productos/{producto}','update');
        Route::patch('productos/{producto}/imagen','updateImagen');
        Route::patch('productos/{producto}/estado','updateEstado');
        Route::patch('productos/{producto}/especificacion-tecnica','updateEspecificacionTecnica');
    });

    Route::controller(ListaPrecioController::class)->group(function (){
        $permiso = 'permission:listaPrecios';
        Route::get('lista-precios','index')->middleware("$permiso:listar");
        Route::get('lista-precios/{listaPrecio}','show')->middleware("$permiso:listar");
        Route::post('lista-precios','store')->middleware("$permiso:crear");
    });

    Route::controller(ListaPrecioProductoController::class)->group(function (){
        $ruta = 'lista-precio-productos';
        $permiso = 'permission:listaPrecios';
        Route::get($ruta,'index')->middleware("$permiso:listar");
        Route::post($ruta,'store')->middleware("$permiso:actualizar");
        Route::patch("$ruta/{listaPrecioProducto}/precio-unitario",'updatePrecioUnitario')->middleware("$permiso:actualizar");
        Route::delete("$ruta/{listaPrecioProducto}",'destroy')->middleware("$permiso:actualizar");
    });

    Route::controller(PedidoController::class)->group(function (){
        Route::get('pedidos','index');
        Route::post('pedidos','store');
        Route::post('pedidos/prueba','prueba');
        Route::post('pedidos/{pedido}/copia','copiarPedido');
        Route::get('pedidos/{pedido}','show');
        Route::put('pedidos/{pedido}/enviar','enviar');
        Route::put('pedidos/{pedido}/atencion','recepcionar');
        Route::put('pedidos/{pedido}/pendiente','pendiente');
        //Route::put('pedidos/{pedido}/entregado','entregado');
        Route::put('pedidos/{pedido}/confirmar','confirmar');
        Route::put('pedidos/{pedido}/cancelar','cancelar');
        Route::get('pedidos/{pedido}/historial','verHistorial');
        Route::get('pedidos/{pedido}/pdf','generarPdf');
        Route::get('pedidos/{pedido}/excel-opa','generarExcel');
    });

    Route::controller(DetallePedidoController::class)->group(function(){
        Route::delete('detalle-pedido/{detallePedido}','destroy');
        Route::patch('detalle-pedido/{detallePedido}/cantidad','updateCantidad');
        Route::patch('detalle-pedido/{detallePedido}/precio','updatePrecio');
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
        Route::get('pedidos/productos-vendidos','productosMasVendidos');
    });
});









