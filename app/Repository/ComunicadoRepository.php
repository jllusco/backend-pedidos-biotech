<?php

namespace App\Repository;

use App\Models\Comunicado;
use Illuminate\Support\Facades\DB;

class ComunicadoRepository {

    public function findAll($request = []){
        $query = Comunicado::query();

        if (!empty($request['search'])) {
            $search = $request['search'];

            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if(isset($request['estado'])){
            $query->where('estado','=',$request['estado']);
        }

        if(isset($request['tipo'])){
            $query->where('tipo','=',$request['tipo']);
        }

        $query->orderBy('created_at','DESC');
        return $query->paginate($request['limit']??10);
    }

    public function getActivosPorUsuario(string $usuarioId)
    {
        return Comunicado::query()
            ->select([
                'comunicado.id',
                'comunicado.titulo',
                'comunicado.descripcion',
                'comunicado.imagen',
                'comunicado.documento',
                'comunicado.tipo',
                'comunicado.audiencia',
                'comunicado.fecha_inicio',
                'comunicado.fecha_fin'
            ])
            ->where('comunicado.estado', 'ACTIVO')
            ->where(function ($q) {
                $q->whereNull('comunicado.fecha_inicio')
                ->orWhereDate('comunicado.fecha_inicio', '<=', now());
            })

            ->where(function ($q) {
                $q->whereNull('comunicado.fecha_fin')
                ->orWhereDate('comunicado.fecha_fin', '>=', now());
            })
            ->where(function ($q) use ($usuarioId) {
                $q->where('comunicado.audiencia', 'GLOBAL')
                  ->orWhereExists(function ($sub) use ($usuarioId) {
                      $sub->select(DB::raw(1))
                          ->from('comunicado_usuario as cu')
                          ->whereColumn('cu.comunicado_id', 'comunicado.id')
                          ->where('cu.usuario_id', $usuarioId);
                  });
            })
            ->orderBy('created_at')
            ->get();
    }
}
