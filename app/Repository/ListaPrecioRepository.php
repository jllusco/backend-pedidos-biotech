<?php

namespace  App\Repository;

use App\Models\ListaPrecio;

class ListaPrecioRepository
{
    public function findAll($request){

        $query = ListaPrecio::query();

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