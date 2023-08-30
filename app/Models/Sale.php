<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Sale extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'id',
        'codigo',
        'total',
        'monto',
        'impuesto',
        'pago',
        'deuda',
        'transaccion',
        'fechaRegistro',
        'idCliente',
        'idUsuario'];
    
    static function getSale($id)
    {
        $venta = new Sale;
        $venta = DB::table('ventas AS V')
        ->join('usuarios AS U', 'U.id', '=', 'V.idUsuario')
        ->join('clientes AS C', 'C.id', '=', 'V.idCliente')
        ->select('V.id AS ID','V.codigo AS codigo','V.total','V.pago AS pago','V.deuda AS deuda','V.cantidad AS cantidad','V.impuesto AS impuesto','V.transaccion AS transaccion','V.fechaRegistro AS fecha','U.nombre AS nombres','U.apellido AS apellidos','C.ci AS CI','C.nombre AS Nombre','C.apellido AS Apellido')
        ->where('V.id',$id)
        ->get();
        return $venta;
    }
    static function getSales()
    {
        $ventas = new Sale;
        $ventas = DB::table('ventas AS V')
        ->join('usuarios AS U', 'U.id', '=', 'V.idUsuario')
        ->join('clientes AS C', 'C.id', '=', 'V.idCliente')
        ->select('V.id AS ID','V.codigo AS codigo','V.total','V.cantidad AS cantidad','V.impuesto AS impuesto','V.fechaRegistro AS fecha','U.nombre AS nombres','U.apellido AS apellidos','C.ci AS CI','C.nombre AS nomC','C.apellido AS apeC')
        ->get();
        return $ventas;
    }
    static function getReportSales($ini,$fin)
    {
        $ventas = new Sale;
        $ventas = DB::table('ventas AS V')
        ->join('usuarios AS U', 'U.id', '=', 'V.idUsuario')
        ->join('clientes AS C', 'C.id', '=', 'V.idCliente')
        ->select('V.id AS ID','V.codigo AS codigo','V.total','V.cantidad AS cantidad','V.impuesto AS impuesto','V.pago AS pagado','V.fechaRegistro AS fecha','U.nombre AS nombres','U.aoellido AS apellidos','C.ci AS CI','C.nombre AS nomC','C.apellido AS apeC')
        ->where('V.fechaRegistro','>=',$ini.' 00:00:00')
        ->where('V.fechaRegistro','<=',$fin.' 23:59:59')
        ->get();
        return $ventas;
    }
    static function getReportSalesMonth($date)
    {
        $dt = Carbon::now();
        $dt->year = substr($date,0,4);
        $dt->month  = substr($date,5,2);
        $ventas = new Sale;
        $ventas = DB::table('ventas AS V')
        ->join('usuarios AS U', 'U.id', '=', 'V.idUsuario')
        ->join('clientes AS C', 'C.id', '=', 'V.idCliente')
        ->select('V.id AS ID','V.codigo AS codigo','V.total','V.impuesto AS impuesto','V.pago AS pagado','V.deuda AS deuda','return AS rollos','V.fechaRegistro','V.transaccion AS transaccion','U.nombre AS nombres','U.apellido AS apellidos','C.ci AS CI','C.nombre AS nomC','C.apellido AS apeC')
        ->where('V.estado','=',1)
        ->where('V.fechaRegistro','>=',$date.'-01 00:00:00')
        ->where('V.fechaRegistro','<=',$date.'-'.$dt->daysInMonth.' 23:59:59')
        ->get();
        return $ventas;
    }
    static function getGains()
    {
        $ventas = new Sale;
        $ventas = Sale::select(DB::raw("MONTH(fechaRegistro) AS Mes"),DB::raw('SUM(total) AS Total'),DB::raw("YEAR(fechaRegistro) AS Gestion"))
        ->groupBy('Mes')
        ->groupBy('Gestion')
        ->orderBy('Gestion')
        ->orderBy('Mes')
        ->get();
        return $ventas;
    }
    static function getYears(){
        $ventas = new Sale;
        $ventas = Sale::select(DB::raw("YEAR(fechaRegistro) AS Year"))
        ->groupBy('Year')
        ->orderBy('Year')
        ->get();
        return $ventas;
    }
    static function getMaxProducts()
    {
        $res = new Sale;
        $res = DB::table('ventadetalles AS DV')
        ->join('materiales AS P', 'P.id', '=', 'DV.idMaterial')
        ->select(DB::raw("SUM(DV.monto) AS Cantidad"),'P.nombre AS nombre',DB::raw("YEAR(DV.fechaRegistro) AS Gestion"))
        ->groupBy('P.nombre')
        ->groupBy('Gestion')
        ->orderBy('Gestion')
        ->orderBy('Cantidad','desc')
        ->get();
        return $res;
    }
}