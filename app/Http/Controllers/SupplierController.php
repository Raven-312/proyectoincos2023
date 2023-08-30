<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(){
        //$data['list'] = Supplier::all('id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','phone AS contacto','email AS correo','address AS direccion','status AS estado','created_at AS fecha');
        $data['list'] = Supplier::paginate($perPage = 500, $columns = ['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','status AS estado'], $pageName = 'suppliers');
        return view('suppliers.list_suppliers',$data);
    }
    
    public function create(){
        return view('suppliers.new_supplier');
    }

    public function store(Request $request){
        $request->validate([
            "ci" => ["bail","required","max:15",Rule::unique('suppliers','ci')],
            "name" => "bail | required | max:50",
            "lastname" => " bail | required | max:50",
            "phone" => "bail | nullable | numeric | digits_between:7,8",
            "email" => "bail | nullable | email | max:50",
            "address" => "bail | nullable"
        ],[        
            "ci.unique" => "Ya existe",    
            "ci.required" => "No debe estar vacio",
            "ci.max" => "Máximo 15 caracteres",
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres",
            "lastname.required" => "No debe estar vacio",
            "lastname.max" => "Máximo 50 caracteres",
            "phone.numeric" => "Solo números",
            "phone.digits_between" => "Tamaño entre 7 y 8 dígitos",
            "email.email" => "Formato de correo no válido",
            "email.max" => "Máximo 50 caracteres",
        ]);
        try {
            DB::beginTransaction();
            $supplier = new Supplier;
            $supplier->ci = $request->ci;
            $supplier->name = $request->name;
            $supplier->lastname = $request->lastname;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->user = session('idSession');
            $supplier->save();
            DB::commit();
            return back()->with('success','Proveedor creado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('suppliers.index');
    }

    public function edit($id){
        $supplier = Supplier::findOrFail($id,['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','phone AS contacto','email AS correo','address AS direccion']);
        return view('suppliers.edit_supplier', compact('supplier'));
    }

    public function update(Request $request,$id){
        $request->validate([
            "name" => "bail | required | max:50",
            "lastname" => " bail | required | max:50",
            "phone" => "bail | nullable | numeric | digits_between:7,8",
            "email" => "bail | nullable | email | max:50",
            "address" => "bail | nullable"
        ],[
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres",
            "lastname.required" => "No debe estar vacio",
            "lastname.max" => "Máximo 50 caracteres",
            "phone.numeric" => "Solo números",
            "phone.digits_between" => "Tamaño entre 7 y 8 dígitos",
            "email.email" => "Formato de correo no válido",
            "email.max" => "Máximo 50 caracteres",
        ]);
        try {
            DB::beginTransaction();
            $supplier = Supplier::findOrFail($id,['id','name','lastname','phone','email','address','user']);
            $supplier->name = $request->name;
            $supplier->lastname = $request->lastname;
            $supplier->phone = $request->phone;
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->user = session('idSession');
            $supplier->update();
            DB::commit();
            return back()->with('success','Proveedor modificado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('suppliers.index');
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            $supplier = new Supplier;
            $supplier = Supplier::findOrFail($id,['id','status']);
            if(verificarEstado($supplier->status)){
                $supplier->status = 0;
            }else{
                $supplier->status = 1;
            }
            $supplier->save();
            DB::commit();
            return Redirect::route('supplier.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('supplier.index');
    }

    public function show(){
        
    }
}