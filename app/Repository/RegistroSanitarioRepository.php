<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 3/4/2024
 * Time: 20:06
 */

namespace App\Repository;


use App\Models\DetallePedido;
use App\Models\RegistroSanitario;
use Carbon\Carbon;

class RegistroSanitarioRepository
{
    public function findAll($request)
    {
        $query = RegistroSanitario::query();

        if (isset($request['numero'])) {
            $query->where('numero', 'like', '%' . $request['numero'] . '%');
        }
        if (isset($request['estado'])) {
            $query->where('estado', '=', $request['estado']);
        }

        $query->addSelect([
            'total_productos' => function ($subQuery) {
                $subQuery->selectRaw('COUNT(1)')
                    ->from('producto')
                    ->whereColumn('registro_sanitario_id', 'registro_sanitario.id')
                    ->whereNull('deleted_at');
            }]);

        $query->orderBy('created_at', 'DESC');
        return $query->paginate($request['limit'] ?? 1000);
    }

    public function findCaducado($days = 0){
        $fechaActual = Carbon::now();
        $fechaActual->addDays($days);
        $query = RegistroSanitario::where('fecha_vencimiento','<=',$fechaActual);
        return $query->get();
    }
}