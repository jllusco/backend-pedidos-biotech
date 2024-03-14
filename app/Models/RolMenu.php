<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 4/3/2024
 * Time: 18:43
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolMenu extends BaseModel
{
    use HasFactory;
        
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'rol_menu';

    protected $fillable = [
        'id',
        'rol_id',
        'menu_id'
    ];

    }