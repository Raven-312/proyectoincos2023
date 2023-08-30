<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(){
        //$data['list'] = Client::all('id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','phone AS contacto','email AS correo','address AS direccion','status AS estado','created_at AS fecha');
        $data['list'] = Client::paginate($perPage = 500, $columns = ['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','status AS estado'], $pageName = 'clients');
        return view('clients.list_clients',$data);
    }
    
    public function create(){
        return view('clients.new_client');
    }

    public function store(Request $request){
        $request->validate([
            "ci" => ["bail","required","max:15",Rule::unique('clients','ci')],
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
            $client = new Client;
            $client->ci = $request->ci;
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->phone = $request->phone;
            $client->email = $request->email;
            $client->address = $request->address;
            $client->user = session('idSession');
            $client->save();
            DB::commit();
            return back()->with('success','Cliente creado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('client.index');
    }

    public function edit($id){
        $client = Client::findOrFail($id,['id AS ID','ci AS CI','name AS nombres','lastname AS apellidos','phone AS contacto','email AS correo','address AS direccion']);
        return view('clients.edit_client', compact('client'));
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
            $client = new Client;
            $client = Client::findOrFail($id,['id','name','lastname','phone','email','address','user']);
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->phone = $request->phone;
            $client->email = $request->email;
            $client->address = $request->address;
            $client->user = session('idSession');
            $client->update();
            DB::commit();
            return back()->with('success','Cliente modificado correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('client.index');
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            $client = new Client;
            $client = Client::findOrFail($id,['id','status']);
            if(verificarEstado($client->status)){
                $client->status = 0;
            }else{
                $client->status = 1;
            }
            $client->save();
            DB::commit();
            return Redirect::route('client.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('client.index');
    }

    public function show()
    {
        
    }
}