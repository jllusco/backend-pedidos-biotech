<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permiso extends BaseSimpleModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'permiso';

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_permiso', 'permiso_id', 'rol_id');
    }
}
