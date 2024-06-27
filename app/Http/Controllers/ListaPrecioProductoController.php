<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\ListaPrecioProductoCollection;
use App\Models\ListaPrecioProducto;
use App\Http\Requests\StoreListaPrecioProductoRequest;
use App\Http\Requests\UpdateListaPrecioProductoRequest;
use App\Repository\ListaPrecioProductoRepository;
use Illuminate\Http\Request;

class ListaPrecioProductoController extends Controller
{
    private $listaPrecioProductoRepositroy;

    public function  __construct(ListaPrecioProductoRepository $listaPrecioProductoRepository){
        $this->listaPrecioProductoRepositroy = $listaPrecioProductoRepository;
    }

    public function index(Request $request){
        try {
            $listaPrecioUsuario = $request->user()->lista_precio_id;
            if(is_null($listaPrecioUsuario)){
                return ApiResponse::error('El usuario no cuenta con una lista de precios');
            }
            $productos = $this->listaPrecioProductoRepositroy->getByListaPrecio($listaPrecioUsuario);
            return ApiResponse::success(new ListaPrecioProductoCollection($productos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

   /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListaPrecioProductoRequest $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePrecioUnitario(ListaPrecioProducto $listaPrecioProducto, Request $request)
    {
        try{
            $precioUnitario = $request->request->get('precioUnitario');
            if(!$precioUnitario)
                return ApiResponse::error('Falta el parametro precio unitario');
            $listaPrecioProducto->update([
                'precio_unitario'=>$precioUnitario,
                //'updated_by'=>$request->user()->id
            ]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaPrecioProducto $listaPrecioProducto)
    {
        try{
            $listaPrecioProducto->delete();
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
