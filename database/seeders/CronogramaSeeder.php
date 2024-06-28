<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 27/6/2024
 * Time: 23:35
 */

namespace Database\Seeders;


use App\Models\Cronograma;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CronogramaSeeder extends Seeder
{
    public  function run():void
    {
        $data=[];
        $meses = [
            'ENERO',
            'FEBRERO',
            'MARZO',
            'ABRIL',
            'MAYO',
            'JUNIO',
            'JULIO',
            'AGOSTO',
            'SEPTIEMBRE',
            'OCTUBRE',
            'NOVIEMBRE',
            'DICIEMBRE'
        ];
        $currentDateTime = Carbon::now();
        for ($i = 1; $i <= 12; $i++) {
            array_push($data,[
                'id'=>(string)Str::uuid(),
                'mes'=>$i,
                'nombre'=>$meses[$i-1],
                'inicio'=>1,
                'fin'=>8,
                'estado'=>'ACTIVO',
                'created_at'=>$currentDateTime,
                'updated_at'=>$currentDateTime,
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ]);
        }

        Cronograma::insert($data);
    }
}