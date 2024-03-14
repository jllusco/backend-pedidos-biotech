<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'rol';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected static function boot()
    {
        parent::boot();
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'rol_menu', 'rol_id', 'menu_id')
            ->withTimestamps()
            ->whereNull('rol_menu.deleted_at');
    }

    public function permisos()
    {
        return $this->belongsToMany(Menu::class, 'rol_permiso', 'rol_id', 'permiso_id');
    }
}
