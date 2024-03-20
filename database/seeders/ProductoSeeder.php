<?php

namespace Database\Seeders;

use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130203001M',
                'nombre' => 'MAGLUMI-TSH',
                'descripcion' => 'MAGLUMI-TSH',
                'categoria_id' => 'e81e9bc8-bb14-42e6-9137-62126b69ee31',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b'
            ],
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130203011M',
                'nombre' => 'MAGLUMI ANTI-TIPO',
                'descripcion' => 'MAGLUMI ANTI-TIPO',
                'categoria_id' => 'e81e9bc8-bb14-42e6-9137-62126b69ee31',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b'
            ],
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130202008M',
                'nombre' => 'MAGLUMI ESTRADIOL(E2)',
                'descripcion' => 'MAGLUMI ESTRADIOL(E2)',
                'categoria_id' => '055a31a4-74f3-46ae-86f1-332226f3d327',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b'
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }

        Producto::insert($data);
    }
}
