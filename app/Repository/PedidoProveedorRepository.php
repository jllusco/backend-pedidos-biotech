<?php

namespace  App\Repository;

use App\Models\PedidoProveedor;

class PedidoProveedorRepository
{
    public function findAll($request){

        $query = PedidoProveedor::with('solicitante');

        if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['tipo'])){
            $query->where('tipo','=',$request['tipo']);
        }
        if(isset($request['created_by'])){
            $query->where('created_by','=',$request['created_by']);
        }

        $query->addSelect([
            'total_productos'=>function($subQuery){
                $subQuery->selectRaw('COUNT(1)')
                    ->from('detalle_pedido_proveedor')
                    ->whereColumn('pedido_proveedor_id', 'pedido_proveedor.id');
            }]);

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }

    public function getCantidad($anio,$mes){
        return PedidoProveedor::query()->whereYear('fecha',$anio)->whereMonth('fecha',$mes)->count();
    }

}