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
        $rolAlmacen = '3d12cb09-91f2-43aa-be60-bbf322116a07';
        $rolCliente = '70796247-01c3-469f-9fae-cd6082ebad86';

        $data = [
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c41'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c42'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c43'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c44'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c45'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c46'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c47'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c48'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c49'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c50'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c51'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c52'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c53'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c54'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c55'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c56'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c57'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c58'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c59'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c60'],
            ['rol_id'=>$rolSuperAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c61'],

            // ADMINISTRADOR
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c41'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c42'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c43'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c45'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c46'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c47'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c48'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c49'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c53'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c54'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c55'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c57'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c58'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c59'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c60'],
            ['rol_id'=>$rolAdmin,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c61'],

            // ALMACEN
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c53'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c54'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c55'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c56'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c57'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c58'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c59'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c60'],
            ['rol_id'=>$rolAlmacen,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c61'],

            // CLIENTE
            ['rol_id'=>$rolCliente,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c48'],
            ['rol_id'=>$rolCliente,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c54'],
            ['rol_id'=>$rolCliente,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c56'],
            ['rol_id'=>$rolCliente,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c57'],
            ['rol_id'=>$rolCliente,'permiso_id'=>'ff077dcb-a058-45c1-8d17-903c4d701c59'],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['id'] = (string)Str::uuid();
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
            $record['created_by'] = config('constants.ID_USUARIO_ADMIN');
        }

        RolPermiso::insert($data);
    }

}