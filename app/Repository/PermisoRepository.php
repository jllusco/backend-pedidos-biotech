<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\Permiso;
use Illuminate\Support\Facades\DB;

class PermisoRepository
{
    public function findAll($request){

        $query = Permiso::query();
        if(isset($request['nombre'])){
            $query->where('nombre','like','%'.$request['nombre'].'%');
        }
        return $query->paginate($request['limit'] ?? 15);
    }

    public function findAllSimple($rolId = null){
        //$permisos = Permiso::all();
        $query = DB::table('permiso','p')
        ->select('p.id')
        ->addSelect('p.nombre');
        if($rolId){
            $query->rightJoin('rol_permiso', 'p.id', '=', 'rol_permiso.permiso_id')
            ->whereNull('rol_permiso.deleted_at')
            ->where('rol_permiso.rol_id','=',$rolId);
        }
        return $query->orderBy('p.nombre')->get();
    }

    // public function eliminarPorRol{
    //     return RolPermiso::where('rol_id', $rolId)->delete();
    // }
}