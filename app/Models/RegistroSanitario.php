<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegistroSanitario extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'registro_sanitario';

    protected $fillable = [
        'id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'ruta_documento',
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class);
    }

    public function getFechaEmisionAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getFechaVencimientoAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
