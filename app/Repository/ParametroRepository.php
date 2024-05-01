<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 10:36
 */

namespace App\Repository;


use App\Models\Parametro;

class ParametroRepository
{
    public function findAll($request){
        $query = Parametro::query();

        if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['nombre'])){
            $query->where('nombre','like','%'.$request['nombre'].'%');
        }
        if(isset($request['grupo'])){
            $query->where('grupo','like','%'.$request['grupo'].'%');
        }
        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }
        return $query->paginate($request['limit']??10);
    }

    public function getGrupos(){
        $query = Parametro::select('grupo')
            ->groupBy('grupo')
            ->get();
        return $query;
    }
}