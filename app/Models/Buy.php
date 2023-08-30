<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Buy extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'id',
        'codigo',
        'total',
        'cantidad',
        'impuesto',
        'transaccion',
        'fechaRegistro',
        'idProveedor',
        'idUsuario'];
    
    static function getBuy($id)
    {
        $compra = new Buy;
        $compra = DB::table('compras AS B')
        ->join('usuarios AS U', 'U.id', '=', 'B.idUsuario')
        ->join('proveedores AS S', 'S.id', '=', 'B.idProveedor')
        ->select('B.id AS ID','B.codigo AS codigo','B.total','B.cantidad AS cantidad','B.impuesto AS impuesto','B.transaccion AS transaccion','B.fechaRegistro AS fecha','U.nombre AS nombres','U.apellido AS apellidos','S.ci AS CI','S.nombre AS nomC','S.apellido AS apeC')
        ->where('B.id',$id)
        ->get();
        return $compra;
    }
    static function getBuys()
    {
        $compras = new Buy;
        $compras = DB::table('compras AS B')
        ->join('usuarios AS U', 'U.id', '=', 'B.idUsuario')
        ->join('proveedores AS S', 'S.id', '=', 'B.idProveedor')
        ->select('B.id AS ID','B.codigo AS codigo','B.total','B.cantidad AS cantidad','B.impuesto AS impuesto','B.fechaRegistro AS fecha','U.nombre AS nombres','U.apellido AS apellidos','S.ci AS CI','S.nombre AS nomC','S.apellido AS apeC')
        ->get();
        return $compras;
    }
    static function getReportBuys($ini,$fin)
    {
        $compras = new Buy;
        $compras = DB::table('compras AS B')
        ->join('usuarios AS U', 'U.id', '=', 'B.idUsuario')
        ->join('proveedores AS S', 'S.id', '=', 'B.idProveedor')
        ->select('B.id AS ID','B.codigo AS codigo','B.total','B.cantidad AS cantidad','B.impuesto AS impuesto','B.fechaRegistro AS fecha','U.nombre AS nombres','U.lastname AS apellidos','S.ci AS CI','s.nombre AS nomC','S.apellido AS apeC')
        ->where('B.fechaRegistro','>=',$ini.' 00:00:00')
        ->where('B.apellido','<=',$fin.' 23:59:59')
        ->get();
        return $compras;
    }
    static function getReportBuysMonth($date)
    {
        $dt = Carbon::now();
        $dt->year = substr($date,0,4);
        $dt->month  = substr($date,5,2);
        $compras = new Buy;
        $compras = DB::table('compras AS B')
        ->join('usuarios AS U', 'U.id', '=', 'B.idUsuario')
        ->join('proveedores AS S', 'C.id', '=', 'B.idProveedor')
        ->select('B.id AS ID','B.codigo AS codigo','B.total','B.impuesto AS impuesto','B.fechaRegistro AS fecha','B.transaccion AS transaccion','U.nombre AS nombres','U.apellido AS apellidos','S.ci AS CI','S.nombre AS nomC','S.apellido AS apeC')
        ->where('B.fechaRegistro','>=',$date.'-01 00:00:00')
        ->where('B.fechaRegistro','<=',$date.'-'.$dt->daysInMonth.' 23:59:59')
        ->get();
        return $compras;
    }
    /*static function getGains(){
        $ventas = new Sale;
        $ventas = Sale::select(DB::raw("MONTH(created_at) AS Mes"),DB::raw('SUM(total) AS Total'),DB::raw("YEAR(created_at) AS Gestion"))
        ->groupBy('Mes')
        ->groupBy('Gestion')
        ->orderBy('Gestion')
        ->orderBy('Mes')
        ->get();
        return $ventas;
    }
    static function getYears(){
        $ventas = new Sale;
        $ventas = Sale::select(DB::raw("YEAR(created_at) AS Year"))
        ->groupBy('Year')
        ->orderBy('Year')
        ->get();
        return $ventas;
    }
    static function getMaxProducts(){
        $res = new Sale;
        $res = DB::table('saledetails AS DV')
        ->join('products AS P', 'P.id', '=', 'DV.product')
        ->select(DB::raw("SUM(DV.amount) AS Cantidad"),'P.name AS nombre',DB::raw("YEAR(DV.created_at) AS Gestion"))
        ->groupBy('P.name')
        ->groupBy('Gestion')
        ->orderBy('Gestion')
        ->orderBy('Cantidad','desc')
        ->get();
        return $res;
    }*/
}