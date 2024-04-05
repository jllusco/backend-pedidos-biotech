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
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b',
                'registro_sanitario_id'=>'a24d1dd1-a39f-4d60-9b93-0e09864cff3a',
                'unidad'=>'KIT',
                'temperatura'=>
                    json_encode([
                        'min'=>2,
                        'max'=>8
                    ]),
                'presentacion_id'=>'1fff193a-6917-4797-a4f1-9ba573fa85af',
                'oferta'=>true
            ],
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130203011M',
                'nombre' => 'MAGLUMI ANTI-TIPO',
                'descripcion' => 'MAGLUMI ANTI-TIPO',
                'categoria_id' => 'e81e9bc8-bb14-42e6-9137-62126b69ee31',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b',
                'registro_sanitario_id'=>'a24d1dd1-a39f-4d60-9b93-0e09864cff3a',
                'unidad'=>'KIT',
                'temperatura'=>json_encode([
                    'min'=>0,
                    'max'=>5
                ]),
                'presentacion_id'=>'1fff193a-6917-4797-a4f1-9ba573fa85af',
                'oferta'=>false
            ],
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130603011M',
                'nombre' => 'MAGLUMI ANTI-TIPO',
                'descripcion' => 'MAGLUMI ANTI-TIPO',
                'categoria_id' => 'e81e9bc8-bb14-42e6-9137-62126b69ee31',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b',
                'registro_sanitario_id'=>'a24d1dd1-a39f-4d60-9b93-0e09864cff3a',
                'unidad'=>'KIT',
                'temperatura'=>
                    json_encode([
                        'min'=>2,
                        'max'=>8
                    ]),
                'presentacion_id'=>'095e9dd8-82fc-4a52-ba9f-f87b3697743c',
                'oferta'=>false
            ],
            [
                'id' => (string)Str::uuid(),
                'codigo' => '130202008M',
                'nombre' => 'MAGLUMI ESTRADIOL(E2)',
                'descripcion' => 'MAGLUMI ESTRADIOL(E2)',
                'categoria_id' => '055a31a4-74f3-46ae-86f1-332226f3d327',
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b',
                'registro_sanitario_id'=>null,
                'unidad'=>'KIT',
                'temperatura'=>json_encode([
                    'min'=>0,
                    'max'=>0
                ]),
                'presentacion_id'=>'1fff193a-6917-4797-a4f1-9ba573fa85af',
                'oferta'=>true
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
