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
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Parametro::insert($data);
    }
}
