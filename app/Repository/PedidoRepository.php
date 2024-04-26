<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\Pedido;

class PedidoRepository
{
    public function findAll($request){

        $query = Pedido::with('solicitante');

        if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }
        if(isset($request['created_by'])){
            $query->where('created_by','=',$request['created_by']);
        }

        $query->addSelect([
            'total_productos'=>function($subQuery){
                $subQuery->selectRaw('COUNT(1)')
                    ->from('detalle_pedido')
                    ->whereColumn('pedido_id', 'pedido.id')
                    ->whereNull('deleted_at');
            }]);

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }

    public function getCantidad($anio,$mes){
        return Pedido::query()->whereYear('fecha',$anio)->count();
    }


    public function getCantidadByEstado(){
        $query = Pedido::selectRaw('estado, COUNT(1) as cantidad')
            ->groupBy('estado')
            ->get();
        return $query;
    }
}