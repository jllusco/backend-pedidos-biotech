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
        if(isset($request['institucion'])){
            $query->where('institucion','=',$request['institucion']);
        }
        if (isset($request['fechaInicio'])) {
            $query->whereRaw('DATE(COALESCE(fecha, created_at)) >= ?', [$request['fechaInicio']]);
            //$query->whereDate('fecha', '>=', $request['fechaInicio']);
        }
        if (isset($request['fechaFin'])) {
            $query->whereRaw('DATE(COALESCE(fecha, created_at)) <= ?', [$request['fechaFin']]);
            //$query->whereDate('fecha', '<=', $request['fechaFin']);
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

    public function getPedidosPendientes(){
        $query = Pedido::query()
            ->where('estado','=','CREADO');
        return $query->get();
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

    public function groupByInstituciones($params = [])
    {
        $query = Pedido::query()
            ->select('institucion')
            ->whereNotNull('institucion')
            ->where('institucion', '!=', '');

        if (!empty($params['created_by'])) {
            $query->where('created_by', $params['created_by']);
        }

        if (!empty($params['search'])) {
            $query->where('institucion','like','%'.$params['search'].'%');
        }

        return $query
            ->groupBy('institucion')
            ->orderBy('institucion', 'ASC')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->institucion,
                    'value' => $item->institucion,
                ];
            });
    }
}
