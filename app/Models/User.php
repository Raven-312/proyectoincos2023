<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Model
{
    use Notifiable;
    protected $table = 'usuarios';
    /**
     * The attributes that are mass assignable.
     *
         * @var array<int, string>
         */
    protected $fillable = 
    [   'id',
        'ci',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'tipo',
        'foto',
        'login',
        'password',
        'estado',
        'idFondos',
        'idUsuario'
    ];
}

