<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Permiso::truncate();

         $data = [
            [
                'id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40',
                'nombre'=>'usuarios:listar',
                'descripcion'=>'Permiso para listar los usuarios',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'792950b1-b5b0-4844-950d-2f89659c5817',
                'nombre'=>'usuarios:crear',
                'descripcion'=>'Permiso para crear usuarios',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Permiso::insert($data);
    }
}
