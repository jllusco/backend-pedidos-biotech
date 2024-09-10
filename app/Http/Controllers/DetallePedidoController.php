<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\DetallePedido;
use App\Http\Requests\StoreDetallePedidoRequest;
use App\Http\Requests\UpdateDetallePedidoRequest;
use App\Repository\DetallePedidoRepository;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    private $detallePedidoRepository;

    public function __construct(DetallePedidoRepository $detallePedidoRepository){
        $this->detallePedidoRepository = $detallePedidoRepository;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetallePedido $detallePedido, Request $request)
    {
        try{
            $pedido = $detallePedido->pedido;
            if($pedido->estado !== 'CREADO')
                return ApiResponse::error('No se puede eliminar el producto, el pedido se encuentra en estado '.$pedido->estado);
            if($pedido->created_by !== $request->user()->id)
                return ApiResponse::error('No se puede eliminar el producto, no es el usuario solicitante');
            $detallePedido->delete();
            $pedido->update(['monto_total'=> $this->detallePedidoRepository->montoTotal($pedido->id)]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }


    public function updateCantidad(DetallePedido $detallePedido, Request $request)
    {
        try{
            $pedido = $detallePedido->pedido;
            if($pedido->estado !== 'CREADO')
                return ApiResponse::error('No se puede actualizar la cantidad, el pedido se encuentra en estado '.$pedido->estado);
            if($pedido->created_by !== $request->user()->id)
                return ApiResponse::error('No se puede actualizar la cantidad, no es el usuario solicitante');
            $cantidad = $request->request->get('cantidad');
            if(!$cantidad)
                return ApiResponse::error('Falta el parametro cantidad');
            $detallePedido->update([
                'cantidad'=>$cantidad,
                'monto'=>$detallePedido->precio * $cantidad
            ]);
            $pedido->update(['monto_total'=> $this->detallePedidoRepository->montoTotal($pedido->id)]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function updatePrecio(DetallePedido $detallePedido, Request $request)
    {
        try{
            $pedido = $detallePedido->pedido;
            if($pedido->estado !== 'EN CURSO')
                return ApiResponse::error('No se puede actualizar el precio, el pedido se encuentra en estado '.$pedido->estado);
            if($pedido->usuario_atencion_id !== $request->user()->id)
                return ApiResponse::error('No se puede actualizar el precio, no es el usuario de almacen');
            $precio = (float)$request->request->get('precio');
            if(!$precio)
                return ApiResponse::error('Falta el parametro precio');
            $detallePedido->update([
                'precio'=>round($precio,2),
                'monto'=>round($precio,2)*$detallePedido->cantidad
            ]);
            $pedido->update(['monto_total'=> $this->detallePedidoRepository->montoTotal($pedido->id)]);
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }
}
