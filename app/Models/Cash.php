<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Cash extends Model
{
    protected $table = 'cashes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id',
        'code',
        'alias',
        'cash',
        'status',
        'created_at',
        'updated_at',
        'user'];

    static function getCashMax(){
        $buy = new Cash;
        $buy = Cash::max('id');
        if($buy == null){
            $buy = Cash::count('id');
        }
        return $buy;
    }
}

