<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 28/6/2024
 * Time: 00:10
 */

namespace App\Http\Controllers;


use App\Helpers\ApiResponse;
use App\Http\Resources\Biotech\CronogramaCollection;
use App\Models\Cronograma;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CronogramaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cronogramas = Cronograma::orderBy('mes')->paginate(12);
            return ApiResponse::success( new CronogramaCollection($cronogramas));
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function update(Cronograma $cronograma,Request $request)
    {
        try {
            $datos = [
                'inicio'=>$request->request->get('inicio',$cronograma->inicio),
                'fin'=>$request->request->get('fin',$cronograma->fin)
            ];
            $cronograma->update($datos);
            return ApiResponse::success( true);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

    public function getConfiguracion()
    {
        try {
            $respuesta = ["mensaje"=>null];
            $fechaActual = Carbon::now();
            $fechaActual->setTime(0,0,0,0);
            $cronogramaActual = Cronograma::query()->where('mes','=',intval($fechaActual->format('m')))->where('estado','=','ACTIVO')->first();
            if($cronogramaActual){
                $fechaIncio = Carbon::create($fechaActual->format('Y'),$cronogramaActual->mes,$cronogramaActual->inicio);
                $fechaFin = Carbon::create($fechaActual->format('Y'),$cronogramaActual->mes,$cronogramaActual->fin);
                if($fechaIncio<=$fechaActual and $fechaFin>=$fechaActual){
                    $respuesta["mensaje"]="Puedes realizar el envio de tu pedido del $cronogramaActual->inicio al $cronogramaActual->fin del mes $cronogramaActual->nombre del año en curso";
                }else{
                    $mesSiguiente = $cronogramaActual->mes ===12?1:$cronogramaActual->mes+1;
                    $cronogramaSiguiente = Cronograma::query()->where('mes','=',intval($mesSiguiente))->where('estado','=','ACTIVO')->first();
                    if($cronogramaSiguiente){
                        $fechaIncio = Carbon::create($fechaActual->format('Y'),$cronogramaSiguiente->mes,$cronogramaSiguiente->inicio);
                        $diasRestantes =$fechaActual->diffInDays($fechaIncio);
                        if($diasRestantes<=8){
                            $respuesta["mensaje"]="Faltan $diasRestantes dias para poder realizar un nuevo pedido";
                        }
                    }
                }
            }
            return ApiResponse::success( $respuesta);
        } catch (\Exception $e) {
            return ApiResponse::exception($e);
        }
    }

}