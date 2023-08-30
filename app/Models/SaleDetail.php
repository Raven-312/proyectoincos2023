<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleDetail extends Model
{
    protected $table = 'saledetails';

    protected $fillable = [
        'id',
        'amount',
        'price',
        'subtotal',
        'observation',
        'created_at',
        'sale',
        'product'];

    static function getSaleDetail($id){
        $detail = new SaleDetail;
        $detail = DB::table('saledetails AS D')
        ->join('products AS P', 'P.id', '=', 'D.product')
        ->select('D.amount AS cantidad','D.price AS precio','D.subtotal','D.observation AS glosa','P.code AS codigo','P.name AS nombre','P.brand AS marca','P.model AS modelo','P.unit AS unidad')
        ->where('D.sale',$id)
        ->get();
        return $detail;
    }
}
