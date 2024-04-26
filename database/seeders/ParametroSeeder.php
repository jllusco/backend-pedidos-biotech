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
                'descripcion'=>'9.96'
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'SIS-005',
                'grupo'=>'SISTEMA',
                'nombre'=>'URL WHATSAPP',
                'descripcion'=>'https://wa.me/59175880746?text=Necesito ayuda BIOTECH'
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'SIS-006',
                'grupo'=>'SISTEMA',
                'nombre'=>'MENSAJE CALENDARIO',
                'descripcion'=>'Los pedidos solo se pueden realizar del 1 al 8 de cada mes del año en curso'
            ],
            [
                'id'=>'1fff193a-6917-4797-a4f1-9ba573fa85af',
                'codigo'=>'PRE-001',
                'grupo'=>'PRESENTACION',
                'nombre'=>'100 DETERMINACIONES',
                'descripcion'=>'PRESENTACION 100 DETERMINACIONES PARA KIT'
            ],
            [
                'id'=>'095e9dd8-82fc-4a52-ba9f-f87b3697743c',
                'codigo'=>'PRE-002',
                'grupo'=>'PRESENTACION',
                'nombre'=>'50 DETERMINACIONES',
                'descripcion'=>'PRESENTACION 50 DETERMINACIONES PARA KIT'
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'PRE-003',
                'grupo'=>'PRESENTACION',
                'nombre'=>'30 DETERMINACIONES',
                'descripcion'=>'PRESENTACION 30 DETERMINACIONES PARA KIT'
            ],
            [
                'id'=>'081a0940-7721-4453-9ed2-669deeeef59d',
                'codigo'=>'PRE-004',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA',
                'descripcion'=>'PRESENTACION EN CAJA'
            ],
            [
                'id'=>'5c779f82-2cef-411c-884a-c58c44a44581',
                'codigo'=>'PRE-005',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA DE 5 VIALES',
                'descripcion'=>'PRESENTACION EN CAJA DE 5 VIALES'
            ],
            [
                'id'=>'7322c4f3-02ed-4810-9214-63171ae0e995',
                'codigo'=>'PRE-006',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA DE 6 VIALES',
                'descripcion'=>'PRESENTACION EN CAJA DE 6 VIALES'
            ],
            [
                'id'=>'8b8f89e4-eff8-4a7d-b039-09841187e63f',
                'codigo'=>'PRE-007',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA DE 1,5 lts x 2 VIALES',
                'descripcion'=>'PRESENTACION EN CAJA DE 1,5 lts x 2 VIALES'
            ],
            [
                'id'=>'2906cf15-f566-464f-9255-d1071d3287a6',
                'codigo'=>'PRE-008',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA DE 10 lts',
                'descripcion'=>'PRESENTACION EN CAJA DE 10 lts'
            ],
            [
                'id'=>'933cceaa-97bb-41a4-847e-e678e122cf7d',
                'codigo'=>'PRE-009',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA POR 2304 TEST',
                'descripcion'=>'PRESENTACION EN CAJA POR 2304 TEST'
            ],
            [
                'id'=>'245756a3-b928-40c0-b59f-6bffe38b559e',
                'codigo'=>'PRE-009',
                'grupo'=>'PRESENTACION',
                'nombre'=>'CAJA POR 546 TEST',
                'descripcion'=>'PRESENTACION EN CAJA POR 546 TEST'
            ],
            [
                'id'=>(string)Str::uuid(),
                'codigo'=>'PRE-010',
                'grupo'=>'PRESENTACION',
                'nombre'=>'FRASCO',
                'descripcion'=>'PRESENTACION EN FRASCO'
            ],
            [
                'id'=>'e361e160-fc96-4bb6-8d65-15507a8159de',
                'codigo'=>'PRE-011',
                'grupo'=>'PRESENTACION',
                'nombre'=>'FRASCO DE 2000 ml',
                'descripcion'=>'PRESENTACION EN FRASCO DE 2000 ml'
            ],
            [
                'id'=> '9c0db592-c763-4a94-a08c-846215c2d16d',
                'codigo'=>'PRE-012',
                'grupo'=>'PRESENTACION',
                'nombre'=>'FRASCO DE 500 ml',
                'descripcion'=>'PRESENTACION EN FRASCO DE 500 ml'
            ],
            [
                'id'=>'41112822-de4d-49b5-b480-47e8c5a73197',
                'codigo'=>'PRE-013',
                'grupo'=>'PRESENTACION',
                'nombre'=>'FRASCO DE 714 ml',
                'descripcion'=>'PRESENTACION EN FRASCO DE 714 ml'
            ],
            [
                'id'=>'a8997755-9a29-41ec-8138-f5f26bcb8156',
                'codigo'=>'PRE-004',
                'grupo'=>'PRESENTACION',
                'nombre'=>'KIT CON REACTIVO R1 y R2',
                'descripcion'=>'PRESENTACION EN KIT CON REACTIVO R1 y R2'
            ],
        ];

        $currentDateTime = Carbon::now();

        foreach ($data as &$record) {
            $record['created_at'] = $currentDateTime;
            $record['updated_at'] = $currentDateTime;
            $record['estado']='ACTIVO';
            $record['created_by']=config('constants.ID_USUARIO_ADMIN');
        }

        Parametro::insert($data);
    }
}
