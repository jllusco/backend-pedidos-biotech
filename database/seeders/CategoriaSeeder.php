<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{

    public function run(): void
    {
        $data = [
            [
                'id'=>'e81e9bc8-bb14-42e6-9137-62126b69ee31',
                'codigo'=>'CAT-001',
                'nombre'=>'TIROIDEAS',
                'descripcion'=>'TIROIDEAS',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
            [
                'id'=>'055a31a4-74f3-46ae-86f1-332226f3d327',
                'codigo'=>'CAT-002',
                'nombre'=>'FERTILIDAD',
                'descripcion'=>'FERTILIDAD',
                'estado'=>'ACTIVO',
                'created_by'=>config('constants.ID_USUARIO_ADMIN')
            ],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Categoria::insert($data);
    }
}
