<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 1/3/2024
 * Time: 15:29
 */
namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'rows' => $this->items->toArray(),
            'pagination' => [
                'total'       => $this->total(),
                'count'       => $this->count(),
                'perPages'     => $this->perPage(),
                'currentPage' => $this->currentPage(),
                'totalPages'  => $this->lastPage(),
            ],
        ];
    }
}