<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class CategoriaRepository
{
    public function findAll($request){

        $query = Categoria::query();

        if(isset($request['search'])){
            $query->where('nombre','like','%'.$request['search'].'%');
        }

        $query->orderBy('nombre','ASC');
        return $query->paginate($request['limit']??10);
    }

}