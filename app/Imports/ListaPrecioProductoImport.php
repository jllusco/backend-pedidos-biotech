<?php

namespace App\Imports;

use App\Models\ListaPrecioProducto;
use App\Models\Producto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\ToModel;

class ListaPrecioProductoImport implements ToCollection
{
    use Importable;

    protected $listaPrecioId;

    public function __construct($listaPrecioId)
    {
        $this->listaPrecioId = $listaPrecioId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $producto = Producto::where('codigo', $row[0])->first();
        if ($producto) {
            ListaPrecioProducto::updateOrCreate(
                [
                    'producto_id' => $producto->id,
                    'lista_precio_id' => $this->listaPrecioId
                ], // Condición de búsqueda
                ['precio_unitario' => round(floatval($row[1]))]
            );
        }
    }

    public function collection(Collection $rows)
    {
        // Skip the header row
        $rows->shift();

        foreach ($rows as $row) {
            // Verifica que la fila tenga al menos 2 columnas
            if (isset($row[0]) && isset($row[1])) {
                $producto = Producto::where('codigo', $row[0])->first();
                if ($producto) {
                    ListaPrecioProducto::updateOrCreate(
                        [
                            'producto_id' => $producto->id,
                            'lista_precio_id' => $this->listaPrecioId
                        ], // Condición de búsqueda
                        ['precio_unitario' => round(floatval($row[1]))]
                    );
                }
            }
        }
    }
}
