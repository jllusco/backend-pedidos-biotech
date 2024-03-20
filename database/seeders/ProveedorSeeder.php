<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=>'06deb956-745d-4d2e-bd72-10e40d59b61b',
                'nombre'=>'SNIBE',
                'origen'=>'CHINA',
                'contacto'=>json_encode([
                    'nombre'=>'JUAN LLUSCO',
                    'telefono'=>'59175880746'
                ]),
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Proveedor::insert($data);
    }
}
