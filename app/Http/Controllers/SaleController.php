<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Movement;
use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use TCPDF;

class SaleController extends Controller
{
    public function index($id){
        $data['cash'] = Cash::findOrFail(session('cashSession'),['id AS ID','code AS codigo','alias AS nombre','cash AS efectivo']);
        $data['client'] = Client::findOrFail($id,['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','status AS estado']);
        $data['user'] = User::findOrFail(session('idSession'),['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos']);
        $data['products'] = Product::select('id AS ID','code AS codigo','name AS nombre','brand AS marca','model AS modelo','unit AS unidad','price AS precio','bottle AS botellas','storage AS almacen')
            ->where('status',1)
            ->get();
        $data['sale'] = Sale::max('id');
        if($data['sale'] == Null){
            $data['sale'] = 0;
        }
        if($data['client']->estado == 0){
            return Redirect::route('client.index');
        }
        return view('shop.sale',$data);
    }
    public function store(Request $request){
        $request->validate([
            "nro" => ["bail","required",Rule::unique('sales','id')],
        ],[        
            "nro.unique" => "La venta anterior ya se realizo",    
        ]);
        try {
            $array = explode(",",$request->codigos);
            for($i=0; $i<count($array); $i++){
                if(($request["cantidad".$array[$i]] == 0) || ($request["cantidad".$array[$i]] == "") || ($request["precio".$array[$i]] == 0) || ($request["precio".$array[$i]] == "")){
                    return Redirect::route('client.index'); 
                }
            }
            $cash = Cash::findOrFail(session('cashSession'));
            if(!verificarEstado($cash->status)){
                return Redirect::route('client.index');
            }
            DB::beginTransaction();
            $res = (double)$cash->cash + (double)$request->pay;
            $cash->cash = $res;
            $cash->update();
            $sale = new Sale;
            $sale->id = (Sale::max('id')+1);
            $sale->code = $request->nro;
            $sale->total = $request->total;
            $sale->pay = $request->pay;
            $sale->debt = $request->debt;
            $sale->amount = $request->cantidad;
            $sale->tax = $request->impuesto;
            $sale->return = $request->bottle;
            $sale->transaction = $request->transaction;
            $sale->client = $request->IDCli;
            $sale->user = session('idSession');
            $sale->save();
            $movement = new Movement;
            $movement->amount = $request->pay;
            $movement->type = 0;
            $movement->description = "Ingreso de Bs ".$request->pay. " por la Venta: ".$sale->code;
            $movement->cash = $cash->id;
            $movement->user = session('idSession');
            $movement->save();
		    for($i=0; $i<count($array); $i++){
                $detail = new SaleDetail;
                $detail->id =(SaleDetail::max('id')+1);
                $detail->amount = $request["cantidad".$array[$i]];
                $detail->price = $request["precio".$array[$i]];
                $detail->subtotal = $request["subtotal".$array[$i]];
                $detail->observation = $request["glosa".$array[$i]];
                $detail->sale = $sale->id;
                $detail->product = $array[$i];
                $detail->save();
		    }
            for($i=0; $i<count($array); $i++){
                $pro = Product::findOrFail($array[$i],['name','bottle']);
                $product = Product::where('unit','Unidad')->where('name',$pro->name)->first();
                $aux = (int)$product->storage - ((int)$request["cantidad".$array[$i]]*(int)$pro->bottle);
                $product->storage = $aux;
                $product->update();
            }
            DB::commit();
            return Redirect::route('sale.show',$request->nro);
        }catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
        return Redirect::route('client.index');
    }
    
    public function show($id){
        $data['sale'] = Sale::getSale($id);
        if(count($data['sale']) > 0){
            $data['detail'] = SaleDetail::getSaleDetail($id);
            $data['id'] = $id;
            return view('shop.sold',$data);
        }
        return view('errors.404');
    }

    public function print($id){
        $sale = Sale::getSale($id);
        $detail = SaleDetail::getSaleDetail($id);
        $detalleQR = "";
        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,array(80,258),true, 'UTF-8', false);
        $pdf = new TCPDF('T', PDF_UNIT,array(215.9,279.4),true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();
        $url = asset('storage/empresa/company.jpg');
        $pdf->Image($url, 20, 5, 45, 25, 'JPG', '', '', true, 180,'', false, false, 0, false, false, false);
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '', 11);
        $pdf->Cell(0, 1, 'N° FACTURA: '.$id, 0, 1, 'R', 0, '', 0);
        foreach($sale as $row){
            $fecha = formatoFechaHoraVista($row->fecha);
            $cli = $row->nomC." ".$row->apeC;
            $user = $row->nombres." ".$row->apellidos;
            $ci = $row->CI;
            $total = $row->total;
            $cantidad = $row->cantidad;
        }
        $detalleQR = 'NroFactura: '.$id.'|Fecha: '.$fecha.'|Cliente: '.$cli.'|Usuario: '.$user.'|CI/NIT: '.$ci.'|Total (Bs): '.$total.'|Cantidad de productos: '.$cantidad.'|DETALLE: ';
        $pdf->Cell(0, 1,'Fecha: '.$fecha, 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'FACTURA', 0, 0, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Dirección: Av. America', 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'COCHABAMBA - BOLIVIA', 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'Cliente: '.$cli , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'Vendedor: '.$user , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'NIT/CI: '.$ci , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'DETALLE', 0, 1, 'C', 0, '', 0);
        $pdf->Ln();
        $num = 1;
        $pdf->Cell(15, 9,'N°', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(35, 9,'CÓDIGO', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(60, 9,'PRODUCTO', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(25, 9,'PRECIO', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(25, 9,'CANTIDAD', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(25, 9,'SUBTOTAL', 1, 0, 'C', 0, '', 0);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        foreach($detail as $row){
            $pdf->Cell(15, 6,$num, 1, 0, 'C', 0, '', 0);
            $pdf->Cell(35, 6,$row->codigo, 1, 0, 'C', 0, '', 0);
            $pdf->Cell(60, 6,$row->nombre, 1, 0, 'L', 0, '', 0);
            $pdf->Cell(25, 6,number_format($row->precio,2), 1, 0, 'R', 0, '', 0);
            $pdf->Cell(25, 6,$row->cantidad, 1, 0, 'R', 0, '', 0);
            $pdf->Cell(25, 6,number_format($row->subtotal,2), 1, 0, 'R', 0, '', 0);
            $detalleQR = $detalleQR.'N°: '.$num.'-Código: '.$row->codigo.'-Producto: '.$row->nombre.'-Precio: '.$row->precio.'-Cantidad: '.$row->cantidad.'-Subtotal: '.$row->subtotal.'|';
            $pdf->Ln();
            $num++;
        }
        $pdf->SetFont('helveticaB', '', 11);
        $pdf->Cell(135, 7,'TOTAL: ', 0, 0, 'R', 0, '', 0);
        $pdf->Cell(25, 7,$cantidad, 1, 0, 'R', 0, '', 0);
        $pdf->Cell(25, 7,number_format($total,2), 1, 0, 'R', 0, '', 0);
        $pdf->Ln();
        $pdf->Cell(180, 7,"Son: ".convertirNumeroALetras($total)." con ".substr(number_format($total,2),-2)."/100 BOLIVIANOS", 0, 1, 'L', 0, '', 0);

        $style = array(
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false
        );
        $large = ($num*6) + 80;
        //qr
        $pdf->write2DBarcode($detalleQR, 'QRCODE,H', 165, $large, 35, 35, $style, 'N');
        $pdf->Output('recibo.pdf','I');
    }
    //imprimir 80mm
    public function print80($id){
        $sale = Sale::getSale($id);
        $detail = SaleDetail::getSaleDetail($id);
        $detalleQR = "";
        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,array(80,258),true, 'UTF-8', false);
        $pdf = new TCPDF('T', PDF_UNIT,array(80,200),true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->AddPage();
        $url = asset('storage/empresa/company.jpg');
        $pdf->Image($url, 19, 5, 45, 25, 'JPG', '', '', true, 150,'', false, false, 0, false, false, false);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 1, 'N° FACTURA: '.$id, 0, 1, 'C', 0, '', 0);
        foreach($sale as $row){
            $fecha = formatoFechaHoraVista($row->fecha);
            $cli = $row->nomC." ".$row->apeC;
            $ci = $row->CI;
            $total = $row->total;
            $cantidad = $row->cantidad;
            $pago = $row->pago;
        }
        $detalleQR = 'NroFactura: '.$id.'|Fecha: '.$fecha.'|Cliente: '.$cli.'|CI/NIT: '.$ci.'|Total (Bs): '.$total.'|Cantidad de productos: '.$cantidad.'|DETALLE: ';
        $pdf->Cell(0, 1,'Fecha: '.$fecha, 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Dirección: Av. America', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'COCHABAMBA - BOLIVIA', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'--------------------------------------------------------', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Cliente: '.$cli , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'NIT/CI: '.$ci , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'--------------------------------------------------------', 0, 1, 'C', 0, '', 0);
        $num = 1;
        $pdf->SetFont('helveticaB', '', 10);
        $pdf->Cell(34, 9,'Concepto', 0, 0, 'L', 0, '', 0);
        $pdf->Cell(18, 9,'Precio', 0, 0, 'R', 0, '', 0);
        $pdf->Cell(18, 9,'Subtotal', 0, 0, 'R', 0, '', 0);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 9);
        foreach($detail as $row){
            $pdf->Cell(34, 6,$row->cantidad.' '.$row->nombre.' - '.substr($row->unidad,0,3), 0, 0, 'L', 0, '', 0);
            $pdf->Cell(18, 6,number_format($row->precio,2), 0, 0, 'R', 0, '', 0);
            $pdf->Cell(18, 6,number_format($row->subtotal,2), 0, 0, 'R', 0, '', 0);
            $detalleQR = $detalleQR.'-Producto: '.$row->nombre.'-Precio: '.$row->precio.'-Cantidad: '.$row->cantidad.'-Subtotal: '.$row->subtotal.'|';
            $pdf->Ln();
            $num++;
        }
        $pdf->SetFont('helveticaB', '', 11);
        $pdf->Ln();
        $pdf->Cell(50, 7,'Total: ', 0, 0, 'L', 0, '', 0);
        $pdf->SetFont('helveticaB', '', 25);
        $pdf->Cell(20, 7,'Bs '.number_format($pago,2), 0, 0, 'R', 0, '', 0);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Ln();
        /*if(strlen(convertirNumeroALetras($total))>10){
            $aux = 0;
            for($i=0;$i<30;$i++){
                if(substr(convertirNumeroALetras($total),$i,1) == " "){
                    $aux++;
                }
                if($aux == 2){
                    $aux = $i;
                    break;
                }
            }
            $pdf->Cell(100, 7,"Son: ".substr(convertirNumeroALetras($total),0,$aux), 0, 1, 'L', 0, '', 0);
            $pdf->Cell(100, 7,"       ".substr(convertirNumeroALetras($total),$aux)." con ".substr(number_format($total,2),-2)."/100 BOLIVIANOS", 0, 1, 'L', 0, '', 0);
        }else{
            $pdf->Cell(100, 7,"Son: ".convertirNumeroALetras($total)." con ".substr(number_format($total,2),-2)."/100 BOLIVIANOS", 0, 1, 'L', 0, '', 0);
        }*/
        $pdf->Cell(0, 1,'--------------------------------------------------------', 0, 1, 'C', 0, '', 0);
        $style = array(
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false
        );
        $large = ($num*6) + 110;
        //qr
        $pdf->write2DBarcode($detalleQR, 'QRCODE,H', 23, $large, 35, 35, $style, 'N');
        $pdf->Output('recibo80mm.pdf','I');
    }
    public function destroy($id){    
        try {
            $cash = Cash::findOrFail(session('cashSession'));
            if(!verificarEstado($cash->status)){
                return Redirect::route('report.sales');
            }
            DB::beginTransaction();
            $sale = new Sale;
            $sale = Sale::findOrFail($id,['id','status','pay']);
            $sale->status = 0;
            $sale->save();
            $cash->cash = $cash->cash - (double)$sale->pay;
            $cash->update();
            $movement = new Movement;
            $movement->amount = (double)$sale->pay;
            $movement->type = 1;
            $movement->description = "Salida por venta anulada de Bs ".(double)$sale->pay. " por la Venta: ".$sale->id;
            $movement->cash = session('cashSession');
            $movement->user = session('idSession');
            $movement->save();
            DB::commit();
            return Redirect::route('report.sales');
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function debt(Request $request){
        try{
            if($request->cobro <= 0){
                return Redirect::route('sale.show',(int)$request->nro);
            }
            DB::beginTransaction();
            $cash = Cash::findOrFail(session('cashSession'));
            $res = (double)$request->pago + (double)$request->cobro;
            $deu = (double)$request->total - (double)$res;
            $total = (double)$cash->cash + (double)$request->cobro;
            $cash->cash = $total;
            $cash->save();
            $sale = Sale::findOrFail($request->nro,['id','pay','debt']);
            $sale->pay = $res;
            $sale->debt = $deu;
            $sale->save();
            $movement = new Movement;
            $movement->amount = (double)$request->cobro;
            $movement->type = 0;
            $movement->description = "Ingreso de deuda de Bs ".(double)$request->pago. " por la Venta: ".$sale->id;
            $movement->cash = session('cashSession');
            $movement->user = session('idSession');
            $movement->save();
            DB::commit();
            return Redirect::route('sale.show',$sale->id);
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
