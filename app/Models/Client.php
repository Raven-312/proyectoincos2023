<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'id',
        'ci',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'direccion',
        'estado',
        'fechaRegistro',
        'fechaActualizacion',
        'user'];
}
