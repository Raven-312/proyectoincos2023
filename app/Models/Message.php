<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'id',
        'to',
        'from',
        'subject',
        'message',
        'status',
        'type',
        'created_at',
        'updated_at'];

    static function getMessages($id){
        $message = DB::table('messages AS M')
        ->join('users AS U', 'U.id', '=', 'M.from')
        ->select('M.id AS ID','M.to AS para','M.subject AS asunto','M.message AS mensaje','M.created_at AS fecha','M.type AS tipo','U.name AS nombres','U.lastname AS apellidos')
        ->where('M.to',$id)
        ->where('M.status',0)
        ->get();
        return $message;
    }
    static function getAllMessages($id){
        $message = DB::table('messages AS M')
        ->join('users AS U', 'U.id', '=', 'M.from')
        ->select('M.id AS ID','M.to AS para','M.message AS mensaje','M.created_at AS fecha','M.type AS tipo','M.status AS estado','U.name AS nombres','U.lastname AS apellidos')
        ->where('M.to',$id)
        ->where('M.to',$id)
        ->orderBy('fecha','desc')
        ->get();
        return $message;
    }
    static function getMessage($id){
        $message = DB::table('messages AS M')
        ->join('users AS U', 'U.id', '=', 'M.from')
        ->select('M.subject AS asunto','M.message AS mensaje','M.created_at AS fecha','U.name AS nombres','U.lastname AS apellidos')
        ->where('M.id',$id)
        ->get();
        return $message;
    }
}
