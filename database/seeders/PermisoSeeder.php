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
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c40','nombre'=>'usuarios:listar','descripcion'=>'Permiso para listar los usuarios'], 
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c41','nombre'=>'usuarios:crear','descripcion'=>'Permiso para crear usuarios'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c42','nombre'=>'usuarios:actualizar','descripcion'=>'Permiso para actualizar usuario'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c43','nombre'=>'usuarios:restaurar:contrasena','descripcion'=>'Permiso para reestablecer la contraseña del usuarios'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c44','nombre'=>'roles:crear','descripcion'=>'Permiso para crear el rol'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c45','nombre'=>'roles:listar','descripcion'=>'Permiso para listar los roles'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c46','nombre'=>'roles:actualizar','descripcion'=>'Permiso para actualizar el rol'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c47','nombre'=>'paramteros:crear','descripcion'=>'Permiso para crear el parametro'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c48','nombre'=>'paramteros:listar','descripcion'=>'Permiso para listar los parametros'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c49','nombre'=>'paramteros:actualizar','descripcion'=>'Permiso para actualizar parametro'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c50','nombre'=>'menus:crear','descripcion'=>'Permiso para crear menu'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c51','nombre'=>'menus:listar','descripcion'=>'Permiso para listar los menus'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c52','nombre'=>'menus:actualizar','descripcion'=>'Permiso para actualzar menus'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c53','nombre'=>'productos:crear','descripcion'=>'Permiso para crear producto'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c54','nombre'=>'productos:listar','descripcion'=>'Permiso para listar los productos'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c55','nombre'=>'productos:actualizar','descripcion'=>'Permiso para actualizar producto'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c56','nombre'=>'pedidos:crear','descripcion'=>'Permiso para crear pedido'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c57','nombre'=>'pedidos:listar','descripcion'=>'Permiso para listar los pedidos'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c58','nombre'=>'pedidos:listar:todo','descripcion'=>'Permiso para listar todos los pedidos'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c59','nombre'=>'pedidos:actualizar','descripcion'=>'Permiso para actualizar el pedido'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c60','nombre'=>'pial:crear','descripcion'=>'Permiso para crear pial'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c61','nombre'=>'pial:listar','descripcion'=>'Permiso para listar los piales'],

             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c62','nombre'=>'listaPrecios:crear','descripcion'=>'Permiso para crear una lista de precio'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c63','nombre'=>'listaPrecios:listar','descripcion'=>'Permiso para listar las listas de precios'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c64','nombre'=>'listaPrecios:actualizar','descripcion'=>'Permiso para actualizar una lista de precio'],

             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c65','nombre'=>'registroSanitario:crear','descripcion'=>'Permiso para crear un registro sanitario'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c66','nombre'=>'registroSanitario:listar','descripcion'=>'Permiso para listar los registros sanitarios'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c67','nombre'=>'registroSanitario:actualizar','descripcion'=>'Permiso para actualizar un registro sanitario'],

             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c68','nombre'=>'cronograma:listar','descripcion'=>'Permiso para crear una lista los cronogramas'],
             ['id'=>'ff077dcb-a058-45c1-8d17-903c4d701c69','nombre'=>'cronograma:actualizar','descripcion'=>'Permiso para actualizar un cronograma']
         ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_by'] = config('constants.ID_USUARIO_ADMIN');
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Permiso::insert($data);
    }
}
