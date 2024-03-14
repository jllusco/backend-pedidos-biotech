<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eliminar datos de la tabla usuario
        // User::truncate();

        $data = [
            [
                'id'=>config('constants.ID_USUARIO_ADMIN'),
                'name'=>'admin',
                'password'=>bcrypt('Developer'),
                'numero_documento'=>'00000000',
                'nombres'=>'AMINISTRADOR DEL SISTEMA',
                'correo_electronico'=>'admin@example.com',
                'rol_id'=>'450f3f9a-d10a-475f-8828-82d0057652c3'
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        // Inserta el array data en la tabla usuario
        User::insert($data);
    }
}
