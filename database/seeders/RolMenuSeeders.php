<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 18:47
 */

namespace Database\Seeders;

use App\Models\RolMenu;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolMenuSeeders extends Seeder
{

    public function run(): void
    {
        $rolSuperAdmin = '450f3f9a-d10a-475f-8828-82d0057652c3';
        $rolAdmin = '7a16f88b-10bb-4a07-9bc2-3458124af968';
        $rolAlmacen = '3d12cb09-91f2-43aa-be60-bbf322116a07';
        $rolCliente = '70796247-01c3-469f-9fae-cd6082ebad86';

        $data = [
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'1b174ed2-e559-4ea1-933d-15ca8c9b7e46',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'ad24e71c-dcd8-4f63-b088-a97efcb2f0bc',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'b4aa6f78-577f-42d0-ad3a-b2eaabc02539',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'26dcb6ff-a0bb-444a-bccd-2e16037fa8c5',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'69811f8e-9296-4b89-a0da-b40d5f01b493',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'9ee88462-5baf-4c9e-83dc-2b19df5cb034',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'77e95c5b-c6c8-4232-a1f5-cd9e47ee6d38',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'81610a1a-8c04-4d52-9fda-a605eac09bf7',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'89fc6a51-8d01-4c72-8fc4-09d57b9be5da',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolSuperAdmin,
                'menu_id'=>'a8cbd7c3-5542-4935-b64c-3be3fa092bac',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            

            // ADMINISTRADOR
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'1b174ed2-e559-4ea1-933d-15ca8c9b7e46',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'26dcb6ff-a0bb-444a-bccd-2e16037fa8c5',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'9ee88462-5baf-4c9e-83dc-2b19df5cb034',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'77e95c5b-c6c8-4232-a1f5-cd9e47ee6d38',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'81610a1a-8c04-4d52-9fda-a605eac09bf7',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'89fc6a51-8d01-4c72-8fc4-09d57b9be5da',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAdmin,
                'menu_id'=>'a8cbd7c3-5542-4935-b64c-3be3fa092bac',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],

            // ALMACEN
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'1b174ed2-e559-4ea1-933d-15ca8c9b7e46',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'9ee88462-5baf-4c9e-83dc-2b19df5cb034',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'77e95c5b-c6c8-4232-a1f5-cd9e47ee6d38',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'81610a1a-8c04-4d52-9fda-a605eac09bf7',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'89fc6a51-8d01-4c72-8fc4-09d57b9be5da',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolAlmacen,
                'menu_id'=>'a8cbd7c3-5542-4935-b64c-3be3fa092bac',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],

            // CLIENTE
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolCliente,
                'menu_id'=>'1b174ed2-e559-4ea1-933d-15ca8c9b7e46',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=> (string)Str::uuid(),
                'rol_id'=>$rolCliente,
                'menu_id'=>'77e95c5b-c6c8-4232-a1f5-cd9e47ee6d38',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'rol_id'=>$rolCliente,
                'menu_id'=>'b2dd187d-902a-4861-bb81-0352491445f7',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        RolMenu::insert($data);
    }

}