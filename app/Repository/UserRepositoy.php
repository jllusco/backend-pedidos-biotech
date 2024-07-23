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

        $query = User::with(['rol','listaPrecio']);

        if(isset($request['usuario'])){
            $query->where('name','like','%'.$request['usuario'].'%');
        }
        if(isset($request['nombres'])){
            $query->where('nombres','like','%'.$request['nombres'].'%');
        }
        if(isset($request['primerApellido'])){
            $query->where('primer_apellido','like','%'.$request['primerApellido'].'%');
        }
        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }
        if(isset($request['institucion'])){
            $query->where('institucion','like','%'.$request['institucion'].'%');
        }
        return $query->paginate($request['limit']??10);
    }

    public function getUsuariosBiotech(){
        return User::whereIn('rol_id',[config('constants.ROL_ADMINISTRADOR'), config('constants.ROL_ALMACEN')])
            ->where('estado','=','ACTIVO')
            ->get();
    }

    public function getUsuariosAlmacen(){
        return User::whereIn('rol_id',[config('constants.ROL_ALMACEN')])
            ->where('estado','=','ACTIVO')
            ->get();
    }
}