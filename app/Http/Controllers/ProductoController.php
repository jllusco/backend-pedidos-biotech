<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\Biotech\ProductoCollection;
use App\Http\Resources\Biotech\ProductoResource;
use App\Repository\ProductoRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            $producto = new ProductoResource(Producto::create($datos));
            return ApiResponse::success($producto);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function show(Producto $producto){
        try {
          $producto->load(['categoria','registroSanitario','presentacion']);
          return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function update(Producto $producto,UpdateProductoRequest $request){
        try {
            $datos = $request->all();
            $datos['temperatura'] = json_encode($datos['temperatura']);
            $producto->update($datos);
            return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateImagen(Producto $producto, Request $request){
        try {
            $imagen = $request->files->get('imagen');
            if(!$imagen){
                throw new \Exception('Debes enviar la imagen',400);
            }
            $folder='image/productos';
            $fileName = (string)Str::uuid().'.'.$imagen->getClientOriginalExtension();
            $imagen->move($folder,$fileName);
            $datos['ruta_imagen']= "$folder/$fileName";
            $producto->update($datos);
            return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateEspecificacionTecnica(Producto $producto, Request $request){
        try {
            $pdf = $request->files->get('documento');
            if(is_null($pdf)){
                throw new \Exception('Debes enviar el documento',400);
            }
            $folder='documentos/productos';
            $fileName = 'et-'.(string)Str::uuid().'.'.$pdf->getClientOriginalExtension();
            $pdf->move($folder,$fileName);
            $datos['ruta_especificacion_tecnica']= "$folder/$fileName";
            $producto->update($datos);
            return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateEstado(Producto $producto, Request $request){
        try {
            $estado = $request->request->get('estado');
            if(!$estado){
                throw new \Exception('Estado es requerido',400);
            }
            $producto->update(['estado'=>$estado]);
            return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updateRegistroSanitario(Producto $producto, Request $request){
        try {
            $registroSanitarioId = $request->request->get('registroSanitarioId',null);
            $producto->update(['registro_sanitario_id'=>$registroSanitarioId]);
            return ApiResponse::success(new ProductoResource($producto));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function  getCantidadesTipo (Request $request){
        try {
            $cantidades = $this->productoRepository ->getCantidadesTipo($request->query->all());
            $respuesta = $cantidades->pluck('count', 'tipo')->all();
            $respuesta['TOTAL']= array_sum($respuesta);
            return ApiResponse::success($respuesta);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }




}
