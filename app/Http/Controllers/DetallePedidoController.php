<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Http\Requests\StoreDetallePedidoRequest;
use App\Http\Requests\UpdateDetallePedidoRequest;
use App\Repository\DetallePedidoRepository;
use App\Http\Resources\Biotech\DetallePedidoResource;
use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    private $detallePedidoRepository;
    private $estadosPermitidos = ['CREADO','CONFIRMADO'];

    public function __construct(DetallePedidoRepository $detallePedidoRepository){
        $this->detallePedidoRepository = $detallePedidoRepository;
    }

    private function validarAcceso($pedido, $user, $accion='registrar'){
        $esUsuarioAlmacen = $user->rol_id === config('constants.ROL_ALMACEN');
        if(!in_array($pedido->estado,$this->estadosPermitidos))
            throw new Exception("El pedido se encuentra en estado {$pedido->estado}");
        if(!$esUsuarioAlmacen && $pedido->created_by !== $user->id)
            throw new Exception("No puedes $accion productos de otros pedidos");
    }

    public function store(StoreDetallePedidoRequest $request){
       try {
            $datos = $request->validated();
            $pedido = Pedido::find($datos['pedido_id']);
            $this->validarAcceso($pedido, $request->user());
            $datos['created_by']=$request->user()->id;
            $detalle = DetallePedido::create($datos);
            $pedido->update(['monto_total'=> $this->detallePedidoRepository->montoTotal($pedido->id)]);
            return ApiResponse::success(new  DetallePedidoResource($detalle));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetallePedido $detallePedido, Request $request)
    {
        try{
            $pedido = $detallePedido->pedido;
            $this->validarAcceso($pedido, $request->user(),'eliminar');
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
            $this->validarAcceso($pedido, $request->user(),'actualizar');
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
