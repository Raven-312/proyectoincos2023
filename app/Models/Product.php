<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'brand',
        'model',
        'unit',
        'price',
        'photo',
        'bottle',
        'storage',
        'status',
        'category',
        'created_at',
        'updated_at',
        'usuario'];
    
    static function getProducts(){
        $productos = new Product;
        $productos = DB::table('products AS P')
        ->join('categories AS C', 'C.id', '=', 'P.category')
        ->select('P.id AS ID','P.code AS codigo','P.name AS nombre','P.brand AS marca','P.model AS modelo','P.unit AS unidad','P.price AS precio','P.photo AS foto','P.status AS estado','bottle AS botellas','storage AS almacen','C.name AS categoria')
        ->distinct()
        ->paginate(250);
        return $productos; 
    }

    static function getProduct($id){
        $producto = new Product;
        $producto = DB::table('products AS P')
        ->join('categories AS C', 'C.id', '=', 'P.category')
        ->select('P.id AS ID','P.code AS codigo','P.name AS nombre','P.brand AS marca','P.model AS modelo','P.unit AS unidad','P.price AS precio','P.photo AS foto','storage AS almacen','C.name AS categoria')
        ->where('P.id',$id)
        ->get();
        return $producto; 
    }
}

