<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'menu';

    protected $fillable = [
        'id',
        'nombre',
        'ruta',
        'icono',
        'orden',
        'estado',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_menu', 'menu_id', 'rol_id')
            ->using(RolMenu::class)
            ->withTimestamps();
    }

}
