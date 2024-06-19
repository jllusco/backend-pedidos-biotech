<?php

namespace  App\Repository;

use App\Models\ListaPrecio;

class ListaPrecioRepository
{
    public function findAll($request){

        $query = ListaPrecio::query();

        /*if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['tipo'])){
            $query->where('tipo','=',$request['tipo']);
        }
        if(isset($request['created_by'])){
            $query->where('created_by','=',$request['created_by']);
        }*/

        $query->addSelect([
            'total_productos'=>function($subQuery){
                $subQuery->selectRaw('COUNT(1)')
                    ->from('lista_precio_producto')
                    ->whereColumn('lista_precio_id', 'lista_precio.id');
            }]);

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }

}