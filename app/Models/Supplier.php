<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    protected $table = 'proveedores';

    public $timestamps = false;
    protected $fillable = 
    [
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
        'idUsuario'
    ];
}
