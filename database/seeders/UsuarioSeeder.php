<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'nombres'=>'SUPER AMINISTRADOR',
                'primer_apellido'=>'BIOTECH',
                'segundo_apellido'=>null,
                'correo_electronico'=>'admin@example.com',
                'rol_id'=>'450f3f9a-d10a-475f-8828-82d0057652c3'
            ],
            [
                'id'=>(string)Str::uuid(),
                'name'=>'almacen.biotech',
                'password'=>bcrypt('Developer'),
                'numero_documento'=>'00000001',
                'nombres'=>'OPERADOR',
                'primer_apellido'=>'ALMACEN',
                'segundo_apellido'=>'BIOTECH',
                'correo_electronico'=>'almacen@biotech.com',
                'rol_id'=>'3d12cb09-91f2-43aa-be60-bbf322116a07'
            ],
            [
                'id'=>(string)Str::uuid(),
                'name'=>'cliente.biotech',
                'password'=>bcrypt('Developer'),
                'numero_documento'=>'00000002',
                'nombres'=>'CLIENTE',
                'primer_apellido'=>'BIOTECH',
                'segundo_apellido'=>null,
                'correo_electronico'=>'cliente@biotech.com',
                'rol_id'=>'70796247-01c3-469f-9fae-cd6082ebad86'
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
