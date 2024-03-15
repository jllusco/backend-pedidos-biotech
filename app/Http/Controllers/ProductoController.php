<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoCollection;
use App\Http\Resources\ProductoResource;
use App\Repository\ProductoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ProductoController extends Controller
{
    private  $productoRepository;

    public function __construct(ProductoRepository $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    public function index(Request $request){
        try {
            $productos = $this->productoRepository->findAll($request->query->all());
            return ApiResponse::success( new ProductoCollection($productos));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreProductoRequest $request){
        try {
            $imagen = $request->files->get('imagen');
            $datos = $request->all();
            $folder='image/productos';
            $datos['ruta_imagen']= "$folder/product-default.png";
            if($imagen){
                $fileName = (string)Str::uuid().'.'.$imagen->getClientOriginalExtension();
                $imagen->move($folder,$fileName);
                $datos['ruta_imagen']= "$folder/$fileName";
            }
            $usuario = new ProductoResource(Producto::create($datos));
            return ApiResponse::success($usuario);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
