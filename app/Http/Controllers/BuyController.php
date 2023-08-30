<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use App\Models\Product;
use App\Models\BuyDetail;
use App\Models\Buy;
use App\Models\Movement;
use App\Models\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use TCPDF;

class BuyController extends Controller
{
    public function index($id){
        $data['cash'] = Cash::findOrFail(session('cashSession'),['id AS ID','code AS codigo','alias AS nombre','cash AS efectivo']);
        $data['supplier'] = Supplier::findOrFail($id,['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','status AS estado']);
        $data['user'] = User::findOrFail(session('idSession'),['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos']);
        $data['products'] = Product::select('id AS ID','code AS codigo','name AS nombre','brand AS marca','model AS modelo','unit AS unidad','price AS precio')
            ->where('status',1)
            ->get();
        $data['buy'] = Buy::max('id');
        if($data['buy'] == Null){
            $data['buy'] = 0;
        }
        if($data['supplier']->estado == 0){
            return Redirect::route('supplier.index');
        }
        return view('shop.buy',$data);
    }
    public function store(Request $request){
        $request->validate([
            "nro" => ["bail","required",Rule::unique('buys','id')],
        ],[        
            "nro.unique" => "La compra anterior ya se realizo",    
        ]);
        try {
            $array = explode(",",$request->codigos);
            for($i=0; $i<count($array); $i++){
                if(($request["cantidad".$array[$i]] == 0) || ($request["cantidad".$array[$i]] == "") || ($request["precio".$array[$i]] == 0) || ($request["precio".$array[$i]] == "")){
                    return Redirect::route('supplier.index'); 
                }
            }
            $cash = new Cash;
            $cash = Cash::findOrFail(session('cashSession'),['id','cash','status']);
            if(!verificarEstado($cash->status)){
                return Redirect::route('supplier.index');
            }
            $res = (double)$cash->cash - (double)$request->total;
            if($res < 0){
                return Redirect::route('supplier.index');
            }
            DB::beginTransaction();
            $cash->cash = $res;
            $cash->update();
            $buy = new Buy;
            $buy->id = (Buy::max('id')+1);
            $buy->code = $request->nro;
            $buy->total = $request->total;
            $buy->amount = $request->cantidad;
            $buy->tax = $request->impuesto;
            $buy->transaction = $request->transaction;
            $buy->supplier = $request->IDSup;
            $buy->user = session('idSession');
            $buy->save();
            $movement = new Movement;
            $movement->amount = $request->total;
            $movement->type = 1;
            $movement->description = "Egreso de Bs ".$request->total. " por la Compra: ".$buy->code;
            $movement->cash = $cash->id;
            $movement->user = session('idSession');
            $movement->save();
		    for($i=0; $i<count($array); $i++){
                $detail = new BuyDetail;
                $detail->id =(BuyDetail::max('id')+1);
                $detail->amount = $request["cantidad".$array[$i]];
                $detail->price = $request["precio".$array[$i]];
                $detail->subtotal = $request["subtotal".$array[$i]];
                $detail->observation = $request["glosa".$array[$i]];
                $detail->buy = $buy->id;
                $detail->product = $array[$i];
                $detail->save();      
		    }
            for($i=0; $i<count($array); $i++){
                $product = new Product;
                $product = Product::findOrFail($array[$i]);
                $aux = (int)$product->storage + (int)$request["cantidad".$array[$i]];
                $product->storage = $aux;
                $product->update();
            }
            DB::commit();
            return Redirect::route('buy.show',$request->nro);
        }catch (\Exception $e) {
            DB::rollBack();
            //return $e;
        }
        return Redirect::route('supplier.index');
    }
    
    public function show($id){
        $data['buy'] = Buy::getBuy($id);
        if(count($data['buy']) > 0){
            $data['detail'] = BuyDetail::getBuyDetail($id);
            $data['id'] = $id;
            return view('shop.bought',$data);
        }
        return view('errors.404');
    }

    public function print($id){
        $buy = Buy::getBuy($id);
        $detail = BuyDetail::getBuyDetail($id);
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
        $pdf->Cell(0, 1, 'N° COMPROBANTE: '.$id, 0, 1, 'R', 0, '', 0);
        foreach($buy as $row){
            $fecha = formatoFechaHoraVista($row->fecha);
            $sup = $row->nomC." ".$row->apeC;
            $user = $row->nombres." ".$row->apellidos;
            $ci = $row->CI;
            $total = $row->total;
            $cantidad = $row->cantidad;
        }
        $detalleQR = 'NroFactura: '.$id.'|Fecha: '.$fecha.'|Proveedor: '.$sup.'|Usuario: '.$user.'|CI/NIT: '.$ci.'|Total (Bs): '.$total.'|Cantidad de productos: '.$cantidad.'|DETALLE: ';
        $pdf->Cell(0, 1,'Fecha: '.$fecha, 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'FACTURA', 0, 0, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Dirección: Av. America', 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'COCHABAMBA - BOLIVIA', 0, 1, 'R', 0, '', 0);
        $pdf->Cell(0, 1,'Proveedor: '.$sup , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'Usuario: '.$user , 0, 1, 'L', 0, '', 0);
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
        $pdf->Output('comprobante.pdf','I');
    }
    //imprimir 80mm
    public function print80($id){
        $buy = Buy::getBuy($id);
        $detail = BuyDetail::getBuyDetail($id);
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
        $pdf->Cell(0, 1, 'N° COMPROBANTE: '.$id, 0, 1, 'C', 0, '', 0);
        foreach($buy as $row){
            $fecha = formatoFechaHoraVista($row->fecha);
            $sup = $row->nomC." ".$row->apeC;
            $ci = $row->CI;
            $total = $row->total;
            $cantidad = $row->cantidad;
        }
        $detalleQR = 'NroFactura: '.$id.'|Fecha: '.$fecha.'|Proveedor: '.$sup.'|CI/NIT: '.$ci.'|Total (Bs): '.$total.'|Cantidad de productos: '.$cantidad.'|DETALLE: ';
        $pdf->Cell(0, 1,'Fecha: '.$fecha, 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Dirección: Av. America', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'COCHABAMBA - BOLIVIA', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'--------------------------------------------------------', 0, 1, 'C', 0, '', 0);
        $pdf->Cell(0, 1,'Proveedor: '.$sup , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'NIT/CI: '.$ci , 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 1,'--------------------------------------------------------', 0, 1, 'C', 0, '', 0);
        $num = 1;
        $pdf->SetFont('helveticaB', '', 10);
        $pdf->Cell(34, 9,'Producto', 0, 0, 'L', 0, '', 0);
        $pdf->Cell(18, 9,'Precio', 0, 0, 'R', 0, '', 0);
        $pdf->Cell(18, 9,'Subtotal', 0, 0, 'R', 0, '', 0);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        foreach($detail as $row){
            $pdf->Cell(34, 6,$row->cantidad.'  '.$row->nombre, 0, 0, 'L', 0, '', 0);
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
        $pdf->Cell(20, 7,'Bs '.number_format($total,2), 0, 0, 'R', 0, '', 0);
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
        $pdf->Output('comprobante80mm.pdf','I');
    }
}
