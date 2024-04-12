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

        $csvFile = database_path('seeders/productos.csv');
        $fileHandle = fopen($csvFile, 'r');
        fgetcsv($fileHandle);
        $produtos = [];
        $currentDateTime = Carbon::now();
        while (($data = fgetcsv($fileHandle,1000,';')) !== false) {
            array_push($produtos,[
                'id' => (string)Str::uuid(),
                'codigo' => $data[0],
                'nombre' => $data[1],
                'descripcion' => $data[1],
                'categoria_id' => null,
                'proveedor_id' => '06deb956-745d-4d2e-bd72-10e40d59b61b',
                'registro_sanitario_id'=>null,
                'unidad'=> $data[2],
                'precio_exwork'=>floatval($data[5]),
                'temperatura'=> $data[4] ===''?
                    json_encode([
                        'min'=>2,
                        'max'=>8
                    ]):null,
                'presentacion_id'=>$data[3],
                'oferta'=>false,
                'tipo'=>$data[6],
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);
        }
        fclose($fileHandle);
        /*$data = [
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
            ]
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
        }*/

        Producto::insert($produtos);
    }
}
