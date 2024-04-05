<?php

namespace Database\Seeders;

use App\Models\Parametro;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'SIS-002',
                'grupo'=>'SISTEMA',
                'nombre'=>'TIPO CAMBIO DOLAR',
                'descripcion'=>'9.96',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'SIS-005',
                'grupo'=>'SISTEMA',
                'nombre'=>'URL WHATSAPP',
                'descripcion'=>'https://wa.me/59175880746?text=Necesito ayuda BIOTECH',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'1fff193a-6917-4797-a4f1-9ba573fa85af',
                'codigo'=>'PRE-001',
                'grupo'=>'PRESENTACION',
                'nombre'=>'100 TEST',
                'descripcion'=>'PRESENTACION 100 TEST PARA KIT',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'095e9dd8-82fc-4a52-ba9f-f87b3697743c',
                'codigo'=>'PRE-002',
                'grupo'=>'PRESENTACION',
                'nombre'=>'50 TEST',
                'descripcion'=>'PRESENTACION 50 TEST PARA KIT',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'PRE-003',
                'grupo'=>'PRESENTACION',
                'nombre'=>'30 TEST',
                'descripcion'=>'PRESENTACION 30 TEST PARA KIT',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'PRE-004',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA',
                'descripcion'=>'PRESENTACION EN CAJA',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'PRE-005',
                'grupo'=>'PRESENTACION',
                'nombre'=>'FRASCO',
                'descripcion'=>'PRESENTACION EN FRASCO',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Parametro::insert($data);
    }
}
