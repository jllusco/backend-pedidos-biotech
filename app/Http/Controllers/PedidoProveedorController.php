<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\DetallePedidoProveedor;
use App\Models\Pedido;
use App\Models\PedidoProveedor;
use App\Http\Requests\StorePedidoProveedorRequest;
use App\Http\Requests\UpdatePedidoProveedorRequest;
use App\Repository\DetallePedidoRepository;
use App\Repository\PedidoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PedidoProveedorController extends Controller
{
    private $pedidoRepository;
    private $detallePedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository, DetallePedidoRepository $detallePedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
        $this->detallePedidoRepository = $detallePedidoRepository;
    }

    public function store(Request $request)
    {
        try {
            $pedidos = Pedido::query()->where('estado','=','EN CURSO')->get();
            $idPedidos = $pedidos->pluck('id')->toArray();
            $productos = new Collection($this->detallePedidoRepository->getByPedidosPial($idPedidos)->toArray());
            $tipos= ['CONSUMIBLE','REACTIVO','RUO'];
            foreach ($tipos as $tipo){
                $productosFiltrados = $productos->filter(function ($producto) use($tipo) {
                    return $producto['tipo'] === $tipo;
                });
                $pial = PedidoProveedor::create([
                    'codigo'=>$this->generarCodigo(),
                    'usuario_solicitante_id'=> $request->user()->id,
                    'nombre_usuario_solicitante'=>
                    'estado'=>'COMPLETADO',
                ]);
                foreach ($productosFiltrados as $producto){
                    DetallePedidoProveedor::create([
                        'pedido_proveedor_id'=>$pial->id,
                        'producto_id'=>$producto['producto_id'],
                        'cantidad'=>$producto['cantidad'],
                        'tipo'=>$producto['tipo'],
                        'precio'=>$producto['precio_exwork'],
                        'monto'=>intval($producto['cantidad'])* doubleval($producto['precio_exwork']),
                        'created_by'=>$request->user()->id
                    ]);
                }
            }
            return ApiResponse::success(true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

}
