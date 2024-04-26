<?php

namespace Database\Seeders;

use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    private $archivos = [
        '130201001M'=>'130201001M.PNG',
        '130201002M'=>'130201002M.png',
        '130201003M'=>'130201003M.png',
        '130201004M'=>'130201004M.png',
        '130201005M'=>'130201005M.png',
        '130201009M'=>'130201009M.png',
        '130201010M'=>'130201010M.PNG',
        '130201011M'=>'130201011M.PNG',
        '130201012M'=>'130201012M.PNG',
        '130201013M'=>'130201013M.PNG',
        '130201014M'=>'130201014M.PNG',
        '130201015M'=>'130201015M.jpg',
        '130201016M'=>'130201016M.jpg',
        '130202001M'=>'130202001M.png',
        '130202002M'=>'130202002M.png',
        '130202003M'=>'130202003M.png',
        '130202006M'=>'130202006M.png',
        '130202007M'=>'130202007M.png',
        '130202009M'=>'130202009M.png',
        '130202010M'=>'130202010M.png',
        '130202011M'=>'130202011M.png',
        '130202012M'=>'130202012M.PNG',
        '130202014M'=>'130202014M.PNG',
        '130203001M'=>'130203001M.png',
        '130203002M'=>'130203002M.png',
        '130203003M'=>'130203003M.png',
        '130203004M'=>'130203004M.png',
        '130203005M'=>'130203005M.jpg',
        '130203006M'=>'130203006M.png',
        '130203007M'=>'130203007M.png',
        '130203008M'=>'130203008M.JPG',
        '130203010M'=>'130203010M.jpeg',
        '130203011M'=>'130203011M.PNG',
        '130601001M'=>'130601001M.PNG',
        '130601002M'=>'130601002M.png',
        '130601003M'=>'130601003M.png',
        '130601004M'=>'130601004M.png',
        '130601005M'=>'130601005M.png',
        '130601009M'=>'130601009M.png',
        '130601010M'=>'130601010M.PNG',
        '130601011M'=>'130601011M.PNG',
        '130601012M'=>'130601012M.PNG',
        '130601013M'=>'130601013M.PNG',
        '130601014M'=>'130601014M.PNG',
        '130601015M'=>'130601015M.jpg',
        '130601016M'=>'130601016M.jpg',
        '130602001M'=>'130602001M.png',
        '130602002M'=>'130602002M.png',
        '130602003M'=>'130602003M.png',
        '130602006M'=>'130602006M.png',
        '130602007M'=>'130602007M.png',
        '130602009M'=>'130602009M.png',
        '130602010M'=>'130602010M.png',
        '130602011M'=>'130602011M.png',
        '130602012M'=>'130602012M.PNG',
        '130602014M'=>'130602014M.jpg',
        '130603001M'=>'130603001M.png',
        '130603002M'=>'130603002M.png',
        '130603003M'=>'130603003M.png',
        '130603005M'=>'130603005M.jpg',
        '130603006M'=>'130603006M.png',
        '130603007M'=>'130603007M.png',
        '130603011M'=>'130603011M.PNG',
        '130614001M'=>'130614001M.jpg',
        '130614002M'=>'130614002M.jpg'
    ];
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
            $archivo = 'image/productos/'.($this->archivos[$data[0]]??'product-default.png');
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
                'ruta_imagen'=> $archivo,
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
