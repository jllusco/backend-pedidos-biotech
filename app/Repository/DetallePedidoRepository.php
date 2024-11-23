<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;


use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;

class DetallePedidoRepository
{
    public function getByPedido($idPedido){
        $query = DetallePedido::with('producto.registroSanitario');
        $query->where('pedido_id','=',$idPedido);
        $query->orderBy('created_at','DESC');
        $resultados = $query->get();

        $resultados = $resultados->sortBy(function($item) {
            return $item->producto->nombre;
        });

        return $resultados->values()->all();
    }

    public function getByPedidoIdProducto($idPedido){
        $query = DetallePedido::select('producto_id');
        $query->where('pedido_id','=',$idPedido);
        $query->orderBy('created_at','DESC');
        return $query->get()->pluck('producto_id')->toArray();
    }

    public function getByPedidosPial($idPedidos){
        $query = DetallePedido::query();
        $query->selectRaw('producto_id, producto.precio_exwork, producto.tipo, SUM(cantidad) as cantidad')
            ->join('producto', 'producto.id', '=', 'producto_id')
            ->whereIn('pedido_id', $idPedidos)
            ->groupBy('producto_id', 'producto.precio_exwork', 'producto.tipo');
        return $query->get();
    }

    public function cantidadProductosPedido($idPedido){
        $query = DetallePedido::where('pedido_id','=',$idPedido)
            ->whereNull('deleted_at')
            ->count();
        return $query;
    }

    public function cantidadProductosSinMonto($idPedido){
        $query = DetallePedido::where('monto','=',0)
            ->where('pedido_id','=',$idPedido)
            ->whereNull('deleted_at')
            ->count();
        return $query;
    }

    public function montoTotal($idPedido){
        $query = DetallePedido::where('pedido_id','=',$idPedido)
            ->whereNull('deleted_at')
            ->sum('monto');
        return $query;
    }

    public function  getSumProductosVendidos(){
        $query = DetallePedido::with('producto')
//            ->whereHas('pedido', function ($query) {
//                $query->whereYear('created_at', now()->year)
//                    ->whereMonth('created_at', now()->month);
//            })
            ->select('producto_id', DB::raw('SUM(cantidad) as cantidad  '))
            ->groupBy('producto_id')
            ->orderByDesc('cantidad');
        return $query->paginate(5);

    }
}