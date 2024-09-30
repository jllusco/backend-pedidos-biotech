<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 22/7/2024
 * Time: 20:56
 */

namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Http\Requests\StoreHistorialStockProductoRequest;
use App\Http\Resources\Biotech\HistorialStockProductoCollection;
use App\Models\HistorialStockProducto;
use App\Models\Producto;
use App\Repository\HistorialStockProductoRepository;
use Illuminate\Http\Request;

class HistorialStockProductoController
{
    private $historialStockRepository;

    public function __construct(HistorialStockProductoRepository $historialStockProductoRepository)
    {
        $this->historialStockRepository = $historialStockProductoRepository;
    }


    public function index(Request $request){
        try {
            $params = $request->query->all();
            $historial = $this->historialStockRepository->findAll($params);
            return ApiResponse::success( new HistorialStockProductoCollection($historial));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function store(StoreHistorialStockProductoRequest $request){
        try {
            $datos = $request->all();
            $producto = Producto::find($datos['producto_id']);
            if($datos['tipo']==='INGRESO'){
                $datos['saldo']=$producto->cantidad_actual + $datos['cantidad'];
            }else{
                $datos['saldo']=$producto->cantidad_actual - $datos['cantidad'];
            }
            HistorialStockProducto::create($datos);
            $producto->update([
                'cantidad_actual'=>$datos['saldo']
            ]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

}