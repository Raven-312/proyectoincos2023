<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BuyDetail extends Model
{
    protected $table = 'buydetails';

    protected $fillable = [
        'id',
        'amount',
        'price',
        'subtotal',
        'observation',
        'created_at',
        'buy',
        'product'];

    static function getBuyDetail($id){
        $detail = new SaleDetail;
        $detail = DB::table('buydetails AS D')
        ->join('products AS P', 'P.id', '=', 'D.product')
        ->select('D.amount AS cantidad','D.price AS precio','D.subtotal','D.observation AS glosa','P.code AS codigo','P.name AS nombre','P.brand AS marca','P.model AS modelo','P.unit AS unidad')
        ->where('D.buy',$id)
        ->get();
        return $detail;
    }
}
