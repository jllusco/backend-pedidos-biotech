<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 18:43
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolPermiso extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'rol_permiso';

    protected $fillable = [
        'id',
        'rol_id',
        'permiso_id'
    ];

}