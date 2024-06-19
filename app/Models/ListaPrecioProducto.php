<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPrecioProducto extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'lista_precio_producto';

    protected $fillable = [
        'id',
        'lista_precio_id',
        'producto_id',
        'precio_unitario'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    protected static function booted()
    {
        static::updated(function ($listaPrecioProducto) {
            $listaPrecio = $listaPrecioProducto->listaPrecio;
            $listaPrecio->updated_by = auth()->id();
            $listaPrecio->touch();
            $listaPrecio->save();
            //$listaPrecioProducto->listaPrecio()->touch();
            //'created_by'=>$request->user()->id
        });
    }

    public function listaPrecio()
    {
        return $this->belongsTo(ListaPrecio::class, 'lista_precio_id');
    }

}
