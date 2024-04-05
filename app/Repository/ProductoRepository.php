<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\Producto;

class ProductoRepository
{
    public function findAll($request){

        $query = Producto::with(['categoria','presentacion','registroSanitario','proveedor']);

        if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['nombre'])){
            $query->where('nombre','like','%'.$request['nombre'].'%');
        }
        if(isset($request['descripcion'])){
            $query->where('descripcion','like','%'.$request['descripcion'].'%');
        }
        if(isset($request['oferta'])){
            $query->where('oferta','=',intval($request['oferta']));
        }
        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }
}