<?php
/**
 * Created by PhpStorm.
 * User: jhon_
 * Date: 27/6/2024
 * Time: 23:31
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends BaseModel
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'cronograma';

    protected $fillable = [
        'id',
        'mes',
        'nombre',
        'inicio',
        'fin',
        'estado'
    ];
}