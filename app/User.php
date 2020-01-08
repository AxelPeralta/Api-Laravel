<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // constantes para verificar si un usuario esta verificado o no

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    // constantes para verificar si un usuario es administrador o no

    const USUARIO_ADMIN = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        
        
    ];

    // mutadores son modificadores antes de insertar datos a la base de datos
    public function setNameAttribute($atributo)
    {
        $this->attributes['name'] = strtolower($atributo);
    }

    public function setEmailAttribute($atributo)
    {
        $this->attributes['email'] = strtolower($atributo);
    }
    // accesores son modificadores no netos al consultar datos despues de ser insertadoes en la base de datos
    public function getNameAttribute($atributo)
    {
        return ucwords($atributo);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //funcion para ver si esta verificado un usuario
    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    //funcion para verificar si es administrador
    public function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMIN;
    }
    //funcion para la generacion del token
    public static function GVT()
    {
        return Str::random(20);
    }
}
