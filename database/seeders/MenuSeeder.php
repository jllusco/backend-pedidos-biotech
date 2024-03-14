<?php

namespace Database\Seeders;

use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=>'1b174ed2-e559-4ea1-933d-15ca8c9b7e46',
                'nombre'=>'Dashboard',
                'ruta'=>'dashboard',
                'icono'=>'dashboard',
                'orden'=>1,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'ad24e71c-dcd8-4f63-b088-a97efcb2f0bc',
                'nombre'=>'Roles',
                'ruta'=>'roles',
                'icono'=>'shield',
                'orden'=>2,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'b4aa6f78-577f-42d0-ad3a-b2eaabc02539',
                'nombre'=>'Menus',
                'ruta'=>'menus',
                'icono'=>'menu',
                'orden'=>3,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'26dcb6ff-a0bb-444a-bccd-2e16037fa8c5',
                'nombre'=>'Usuarios',
                'ruta'=>'usuarios',
                'icono'=>'people',
                'orden'=>4,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'69811f8e-9296-4b89-a0da-b40d5f01b493',
                'nombre'=>'Parametros',
                'ruta'=>'parametros',
                'icono'=>'settings',
                'orden'=>8,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'9ee88462-5baf-4c9e-83dc-2b19df5cb034',
                'nombre'=>'Inventario',
                'ruta'=>'inventario',
                'icono'=>'inventory',
                'orden'=>9,
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Menu::insert($data);
    }
}
