<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Produc;
use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use TCPDF;

class ReportController extends Controller
{
    public function sales(){
        $data['list'] = Sale::getReportSalesMonth(date('Y-m'));
        return view('reports.sales',$data);
    }
    public function printsales(Request $request){
        $sales = Sale::getReportSales($request->ini,$request->fin);
        $pdf = new TCPDF('L', PDF_UNIT,array(215.9,279.0),true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $img = asset('storage/empresa/company.jpg');
        $pdf->Image($img, 20, 5, 70, 20, 'JPG', '', '', true, 150,'', false, false, 0, false, false, false);
        $pdf->Ln();
        $pdf->SetFont('helveticaB', '', 15);
        $pdf->Cell(0, 1,'REPORTE DE VENTAS', 0, 0, 'C', 0, '', 0);
        $pdf->SetFont('helveticaB', '', 11);
        $pdf->Ln();
        $pdf->Ln();
        $num = 1;
        $pdf->Cell(15, 10,'N°', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(35, 10,'CÓDIGO', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(35, 10,'FECHA', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(70, 10,'CLIENTE', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(70, 10,'VENDEDOR', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(25, 10,'TOTAL (Bs)', 1, 0, 'C', 0, '', 0);
        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 11);
        $total = 0;
        foreach($sales as $row){
            $pdf->Cell(15, 7,$num, 1, 0, 'C', 0, '', 0);
            $pdf->Cell(35, 7,$row->codigo, 1, 0, 'C', 0, '', 0);
            $pdf->Cell(35, 7,formatoFechaHoraVista($row->fecha), 1, 0, 'L', 0, '', 0);
            $pdf->Cell(70, 7,$row->nomC.' '.$row->apeC, 1, 0, 'L', 0, '', 0);
            $pdf->Cell(70, 7,$row->nombres.' '.$row->apellidos, 1, 0, 'L', 0, '', 0);
            $pdf->Cell(25, 7,number_format($row->pagado,2), 1, 0, 'R', 0, '', 0);
            $pdf->Ln();
            $total = $total + $row->pagado;
            $num++;
        }
        $pdf->SetFont('helveticaB', '', 11);
        $pdf->Cell(225, 7,'TOTAL: ', 0, 0, 'R', 0, '', 0);
        $pdf->Cell(25, 7,number_format($total,2), 1, 0, 'R', 0, '', 0);
        //$pdf->Output('reporteCompras.pdf','I');
        $pdf->Output('reporteVentas.pdf','I');
    }
    public function sale(Request $request){
        $data = Sale::getSale($request->nro);
        return $data->toJson();
    }
    public function reportsales($date){
        $data['list'] = Sale::getReportSalesMonth($date);
        return view('reports.sales',$data);
    }
    public function deptors(){
        $data['list'] = Sale::getReportSalesMonth(date('Y-m'));
        return view('reports.deptors',$data);
    }
    public function bottles(Request $request){
        try{
            DB::beginTransaction();
            if($request->pago>0 && $request->pago!=""){
                $movement = new Movement;
                $movement->amount = $request->pago;
                $movement->type = 0;
                $movement->description = "Ingreso de Bs ".$request->pago. " por reposición de botellas";
                $movement->cash = session('cashSession');
                $movement->user = session('idSession');
                $movement->save();
            }
            if($request->botellas>0 && $request->botellas!=""){
                $sale = Sale::findOrFail($request->nroVenta,['id','return']);
                $sale->return = (integer)$sale->return - (integer)$request->botellas;
                $sale->save();
            }
            DB::commit();
            return Redirect::route('sale.show',$sale->id);
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }
    public function catalog(){
        $products = Product::all(['code']);
        $pdf = new TCPDF('L', PDF_UNIT,array(215.9,279.0),true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $style = array(
            //'position' => 'L',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '0',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $k=1;
        $x = 8;
        $y = 8;
        foreach($products as $row){
            $tam = strlen($row->code);
            if($tam == 10){
                $pdf->write1DBarcode($row->code, 'C128C', $x, $y, '', 18, 0.4, $style, 'N');
                if($k==5){
                    $x = 8;
                    $y = $y + 24;
                    $k=0;
                }else{
                    $x = $x + 50;
                }
                $k++;
            }else{
            }
        }
        $pdf->Output('catalogo.pdf','I');
    }
}
