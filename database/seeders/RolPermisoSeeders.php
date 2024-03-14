<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 18:47
 */

namespace Database\Seeders;

use App\Models\RolPermiso;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolPermisoSeeders extends Seeder
{

    public function run(): void
    {
        $rolSuperAdmin = '450f3f9a-d10a-475f-8828-82d0057652c3';
        $rolAdmin = '7a16f88b-10bb-4a07-9bc2-3458124af968';
        $data = [
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'permiso_id'=>'792950b1-b5b0-4844-950d-2f89659c5817',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            // ADMINISTRADOR
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'permiso_id'=>'792950b1-b5b0-4844-950d-2f89659c5817',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        RolPermiso::insert($data);
    }

}