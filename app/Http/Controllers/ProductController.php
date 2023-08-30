<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class ProductController extends Controller
{
    public function index(){
        $data['list'] = Product::getProducts();
        return view('products.list_products',$data);
    }
        
    public function create(){
        $data['list'] = Category::select('id AS ID','name AS nombre','status AS estado')->where('status', 1)->get();
        return view('products.new_product',$data);
    }

    public function store(Request $request){
        $request->validate([
            "code" => ["bail","required","between:10,13",Rule::unique('products','code')],
            "name" => "bail | required | max:50",
            "brand" => " bail | required | max:50",
            "model" => "bail | nullable | max:50",
            "price" => "bail | numeric | between:0,9999999",
            "photo" => "bail | nullable | image"
        ],[        
            "code.unique" => "Ups!!! Actualizar",
            "code.required" => "No debe estar vacio",
            "code.between" => "Debe tener 10 o 13 dígitos",
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres",
            "brand.required" => "No debe estar vacio",
            "brand.max" => "Máximo 50 caracteres",
            "model.max" => "Máximo 50 caracteres",
            "price.numeric" => "Solo se admiten números",
            "price.between" => "Rango permitido entre 0 y 9999999",
            "photo.image" => "Solo formato de imágenes",
        ]);
        try {
            DB::beginTransaction();
            $product = new Product;
            $product->code = $request->code;
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->model = $request->model;
            $product->unit = $request->unit;
            $product->price = $request->price;
            $product->bottle = $request->bottle;
            $product->storage = $request->storage;
            if($request->hasFile('photo')){
                $product->photo = $request->file('photo')->store('products','public');
            }
            $product->category = $request->category;
            $product->user = session('idSession');
            $product->save();
            DB::commit();
            return back()->with('success','Producto creado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('product.index');
    }

    public function edit($id){
        $data['product'] = Product::findOrFail($id,['id AS ID','code AS codigo','name AS nombre','brand AS marca','model AS modelo','unit AS unidad','price AS precio','photo AS foto','bottle AS botellas','storage AS almacen','category AS categoria']);
        $data['categories'] = Category::all('id AS ID','name AS nombre');
        return view('products.edit_product', $data);
    }

    public function update(Request $request,$id){
        $request->validate([
            "name" => "bail | required | max:50",
            "brand" => " bail | required | max:50",
            "model" => "bail | nullable | max:50",
            "price" => "bail | numeric | between:0,9999999",
            "photo" => "bail | nullable | image"
        ],[        
            "code.unique" => "Ups!!! Actualizar",
            "code.required" => "No debe estar vacio",
            "code.size" => "Debe tener 10 dígitos",
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres",
            "brand.required" => "No debe estar vacio",
            "brand.max" => "Máximo 50 caracteres",
            "model.max" => "Máximo 50 caracteres",
            "price.numeric" => "Solo se admiten números",
            "price.between" => "Rango permitido entre 0 y 9999999",
            "photo.image" => "Solo formato de imágenes",
        ]);
        try {
            DB::beginTransaction();
            $product = new Product;
            $product = Product::findOrFail($id,['id','name','brand','model','unit','price','photo','category','user']);
            $product->name = $request->name;
            $product->brand = $request->brand;
            $product->model = $request->model;
            $product->unit = $request->unit;
            $product->price = $request->price;
            $product->bottle = $request->bottle;
            $product->storage = $request->storage;
            $product->category = $request->category;
            if($request->hasFile('photo')){
                if($product->photo != 'products/default_product.jpg'){
                    Storage::delete('public/'.$product->photo);
                }
                $product->photo = $request->file('photo')->store('products','public');
            }
            $product->user = session('idSession');
            $product->update();
            DB::commit();
            return back()->with('success','Producto modificado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('product.index');
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            $product = new Product();
            $product = Product::findOrFail($id,['id','status']);
            if(verificarEstado($product->status)){
                $product->status = 0;
            }else{
                $product->status = 1;
            }
            $product->save();
            DB::commit();
            return Redirect::route('product.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function show($id){
        $product = Product::findOrFail($id,['code','status']);
        if(!verificarEstado($product->status)){
            return Redirect::route('product.index');;
        }
        $pdf = new TCPDF('L', PDF_UNIT,array(215.9,279.5),true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetFont('helvetica', '', 11);
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
        $tam = strlen($product->code);
        $x = 8;
        $y = 8;
        if($tam == 10){
            for($i=0;$i<6;$i++){
                for($j=0;$j<10;$j++){
                    if($tam == 10){
                        $pdf->write1DBarcode($product->code, 'C128C', $x, $y, '', 18, 0.4, $style, 'N');
                        $y = $y + 18;
                    }
                }
                $y = 8;
                $x = $x + 44;
            }
        }else{
            for($i=0;$i<4;$i++){
                for($j=0;$j<10;$j++){
                    $pdf->write1DBarcode($product->code, 'C128A', $x, $y, '', 18, 0.33, $style, 'N');
                    $y = $y + 18;
                }
                $y = 8;
                $x = $x + 66;
            }
        }
        $pdf->Output('codeProduct.pdf','I');
    }
}
