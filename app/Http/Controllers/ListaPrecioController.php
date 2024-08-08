<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\ListaPrecioCollection;
use App\Http\Resources\Biotech\ListaPrecioProductoCollection;
use App\Http\Resources\Biotech\ListaPrecioProductoResource;
use App\Http\Resources\Biotech\ListaPrecioResource;
use App\Models\Lista;
use App\Http\Requests\StoreListaPrecioRequest;
use App\Http\Requests\UpdateListaPrecioRequest;
use App\Http\Resources\Biotech\ListaCollection;
use App\Models\ListaPrecio;
use App\Models\ListaPrecioProducto;
use App\Repository\ListaPrecioProductoRepository;
use App\Repository\ListaPrecioRepository;
use Illuminate\Http\Request;

class ListaPrecioController extends Controller
{
    private $listaPrecioRepository;
    private $listaPrecioProductoRepositroy;

    public function __construct(ListaPrecioRepository $listaPrecioRepository,
        ListaPrecioProductoRepository $listaPrecioProductoRepository
    ){
        $this->listaPrecioRepository = $listaPrecioRepository;
        $this->listaPrecioProductoRepositroy = $listaPrecioProductoRepository;
    }

    public function index(Request $request){
        try {
            $productos = $this->listaPrecioRepository->findAll($request->query->all());
            return ApiResponse::success( new ListaPrecioCollection($productos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreListaPrecioRequest $request){
        try{
            $datos = $request->request->all();
            $productos = $request->get('productos');
            if(count($productos)===0){
                return ApiResponse::error('El pedido debe tener al menos un producto');
            }
            $listaPrecio = ListaPrecio::create($datos);
            foreach ($productos as $producto) {
                ListaPrecioProducto::create([
                    'lista_precio_id'=>$listaPrecio->id,
                    'producto_id'=>$producto['id'],
                    'precio_unitario'=>$producto['nuevoPrecioUnitario'],
                    'created_by'=>$request->user()->id
                ]);
            }
            return ApiResponse::success(new ListaPrecioResource($listaPrecio));
        }catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function addProducto(ListaPrecio $listaPrecio, Request $request){
        try{
            $datos = $request->request->all();
            $listaPrecioProducto = ListaPrecioProducto::create([
                'lista_precio_id'=>$listaPrecio->id,
                'producto_id'=>$datos['id'],
                'precio_unitario'=>$datos['nuevoPrecioUnitario'],
                'created_by'=>$request->user()->id
            ]);
            $listaPrecioProducto->producto;
            return ApiResponse::success(new ListaPrecioProductoResource($listaPrecioProducto));
        }catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(ListaPrecio $listaPrecio){
        try {
            $productos = $this->listaPrecioProductoRepositroy->getByListaPrecio($listaPrecio->id);
            return ApiResponse::success([
                'listaPrecio'=>new ListaPrecioResource($listaPrecio),
                'productos'=>new ListaPrecioProductoCollection($productos)
            ]);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
