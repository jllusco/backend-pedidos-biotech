<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\User;

class UserRepositoy
{
    public function findAll($request){

        $query = User::with('rol');

        if(isset($request['usuario'])){
            $query->where('name','like','%'.$request['usuario'].'%');
        }
        if(isset($request['nombres'])){
            $query->where('nombres','like','%'.$request['nombres'].'%');
        }
        if(isset($request['primerApellido'])){
            $query->where('primer_apellido','like','%'.$request['primerApellido'].'%');
        }
        return $query->paginate($request['limit']??15);
    }
}