<?php

namespace Database\Seeders;

use App\Models\RegistroSanitario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RegistroSanitarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id'=>'a24d1dd1-a39f-4d60-9b93-0e09864cff3a',
                'numero'=>'RI-0000/2024',
                'fecha_emision'=>'2024-04-02',
                'fecha_vencimiento'=>'2029-04-02',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        RegistroSanitario::insert($data);
    }
}
