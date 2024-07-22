<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    // protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nombres',
        'tipo_documento',
        'numero_documento',
        'primer_apellido',
        'segundo_apellido',
        'celular',
        'estado',
        'rol_id',
        'lista_precio_id',
        'correo_electronico',
        'password',
        'departamento',
        'institucion',
        'sistema'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
        });
    }

   /* public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    public function getAuthPassword()
    {
        return 'contrasena';
    }*/

    public function getNombreCompletoAttribute()
    {
        return trim("$this->nombres $this->primer_apellido $this->segundo_apellido");
    }

    public function rol(){
       return $this->belongsTo(Rol::class);
    }

    public function listaPrecio(){
        return $this->belongsTo(ListaPrecio::class);
    }

    public function routeNotificationForMail($notification){
        return $this->correo_electronico;
    }
}
