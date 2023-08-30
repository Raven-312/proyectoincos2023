<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movement extends Model
{
    protected $table = 'movements';

    protected $fillable = [
        'id',
        'amount',
        'type',
        'description',
        'created_at',
        'updated_at',
        'cash',
        'user'];

    static function getMovements(){
        $movement = new Product;
        $movement = DB::table('movements AS M')
        ->join('cashes AS C', 'C.id', '=', 'M.cash')
        ->join('users AS U', 'U.id', '=', 'M.user')
        ->select('M.id AS ID','M.amount AS monto','M.type AS tipo','M.description AS descripcion','M.created_at AS fecha','C.code AS codigo','C.alias AS nombre','C.cash AS efectivo','U.name AS nombres','U.lastname AS apellidos')
        ->orderBy('fecha','desc')
        ->paginate(500);
        return $movement;
    }
}