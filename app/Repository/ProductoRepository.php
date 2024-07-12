<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 7/3/2024
 * Time: 12:28
 */
namespace  App\Repository;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ProductoRepository
{
    public function findAll($request){

        $query = Producto::with(['categoria','presentacion','registroSanitario','proveedor']);

        if(isset($request['codigo'])){
            $query->where('codigo','like','%'.$request['codigo'].'%');
        }
        if(isset($request['search'])){
            $query->where('codigo','like','%'.$request['search'].'%')
            ->orWhere('nombre','like','%'.$request['search'].'%');
        }else{
            if(isset($request['nombre'])){
                $query->where('nombre','like','%'.$request['nombre'].'%');
            }
            if(isset($request['descripcion'])){
                $query->where('descripcion','like','%'.$request['descripcion'].'%');
            }
        }
        if(isset($request['idCategoria'])){
            $query->where('categoria_id','=',$request['idCategoria']);
        }
        if(isset($request['registroSanitarioId'])){
            $query->where('registro_sanitario_id','=',$request['registroSanitarioId']);
        }
        if(isset($request['oferta'])){
            $query->where('oferta','=',intval($request['oferta']));
        }
        if(isset($request['tipo'])){
            $query->where('tipo','=',$request['tipo']);
        }
        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }
        if(isset($request['registroSanitario'])){
            $tipoRegistroSanitario = $request['registroSanitario'];
            if($tipoRegistroSanitario === 'SIN REGISTRO'){
                $query->whereNull('registro_sanitario_id');
            }
            if($tipoRegistroSanitario === 'REGISTRO CADUCADO'){
                $query->whereHas('registroSanitario',function ($subQuery) {
                    $subQuery->where('fecha_vencimiento', '<', now());
                });
            }
        }

        $query->orderBy('nombre','ASC');
        return $query->paginate($request['limit']??10);
    }

    public function getCantidadesTipo($request=[]){
        $query= Producto::selectRaw('tipo, COUNT(*) as count')
            ->groupBy('tipo');
        if(isset($request['registroSanitario'])){
            $tipoRegistroSanitario = $request['registroSanitario'];
            if($tipoRegistroSanitario === 'SIN REGISTRO'){
                $query->whereNull('registro_sanitario_id');
            }
        }
         return $query->get();
    }
}