<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $data['list'] = User::select('id','ci','nombre','apellido','apellido2','telefono','email','tipo AS tipo','foto AS foto','login AS login','estado AS estado')
            ->where('id','!=',session('idSession'))
            ->get();
        return view('users.list_users',$data);
    }

    public function create()
    {
       
        $data['list'] = Cash::select('id','codigo','alias')->where('estado', 1)->get();
        return view('users.new_user',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "bail | required | max:50",
            "apellido" => " bail | required | max:50",
            "apellido2" => " bail | nullable | max:50",
            "ci" => " bail | required | max:15",
            "telefono" => "bail | required | numeric | digits_between:7,8",
            "email" => "bail | nullable | email | max:50",
            "foto" => "bail | nullable | image",
            "login" => ["bail","required","min:3","max:20",Rule::unique('usuarios','login')],
            "password" => ["bail","required","confirmed",Password::min(14)->letters()->mixedCase()->numbers()->symbols()],
        ],[
            "nombre.required" => "No debe estar vacio",
            "nombre.max" => "Máximo 50 caracteres",
            "apellido.required" => "No debe estar vacio",
            "apellido.max" => "Máximo 50 caracteres",
            "ci.required" => "No debe estar vacio",
            "ci.max" => "Máximo 15 caracteres",
            "telefono.numeric" => "Solo números",
            "telefono.digits_between" => "Tamaño entre 7 y 8 dígitos",
            "email.email" => "Formato de correo no válido",
            "email.max" => "Máximo 50 caracteres",
            "foto.image" => "Solo formato de imágenes",
            "login.required" => "No debe estar vacio",
            "login.min" => "Mínimo 3 caracteres",
            "login.max" => "Máximo 50 caracteres",
            "login.unique" => "El nombre de usuario ya existe",
            "password.required" => "No debe estar vacio",
            "password.confirmed" => "Contraseñas no coinciden",
            "password.min" => "Mínimo 14 caracteres",
        ]);
        try 
        {
            DB::beginTransaction();
            $user = new User;
            $user->ci = $request->ci;
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->apellido2 = $request->apellido2;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->tipo = $request->access;
          if($request->hasFile('foto'))
            {
                $user->foto = $request->file('foto')->store('users','public');
            }
            $user->login = $request->login;
            $user->password = Hash::make($request->password);
           $user->idUsuario = session('idSession');
            $user->idFondos = $request->idFondos;

            $user->save();

            DB::commit();
          return back()->with('success','Usuario creado correctamente');

        }
        catch (\Exception $e)
         {
        DB::rollBack();
        }
        return Redirect::route('user.index');
    }

    public function edit($id)
    {
        $data['list'] = Cash::select('id','codigo','alias')->where('estado', 1)->get();
        $user = User::findOrFail($id);
        if($id == session('idSession'))
        {
            return view('users.update_me', compact('user'));
        }
        return view('users.edit_user', compact('user'),$data);
    }

    public function update(Request $request,$id)
    {
        $request->validate
           (
            [
            "nombre" => "bail | required | max:50",
            "apellido" => " bail | required | max:50",
            "apellido2" => " bail | nullable | max:50",
            "ci" => " bail | required | max:15",
            "telefono" => "bail | required | numeric | digits_between:7,8",
            "email" => "bail | nullable | email | max:50",
            "foto" => "bail | nullable | image",
            "login" => ["bail","nullable","min:3","max:50"],
            "password" => ["bail","nullable","confirmed",Password::min(14)->letters()->mixedCase()->numbers()->symbols()],
            "passwordAdmin" => "bail | required"
        ],
        [
            "nombre.required" => "No debe estar vacio",
            "nombre.max" => "Máximo 50 caracteres",
            "apellido.required" => "No debe estar vacio",
            "apellido.max" => "Máximo 50 caracteres",
            "ci.required" => "No debe estar vacio",
            "ci.max" => "Máximo 15 caracteres",
            "telefono.numeric" => "Solo números",
            "telefono.digits_between" => "Tamaño entre 7 y 8 dígitos",
            "email.email" => "Formato de correo no válido",
            "email.max" => "Máximo 50 caracteres",
            "foto.image" => "Solo formato de imágenes",
            "login.min" => "Mínimo 3 caracteres",
            "login.max" => "Máximo 50 caracteres",
            "password.confirmed" => "Contraseñas no coinciden",
            "password.min" => "Mínimo 14 caracteres",
            "passwordAdmin.required" => "Se requiere para validar la operación" 
        ]); 
        try
         {
            DB::beginTransaction();
            $user = new User;
            $admin = new User;
            $user = User::findOrFail($id);
            $admin = User::select('id','password','estado AS estado')
              ->where('login',session('usernameSession'))
                ->get();
            $admin->toJson();
            //verificar el usuario creado
            if(count($admin) > 0)
            {
              foreach ($admin as $row) 
              {
                  $pass = $row["password"];
                   $est = $row["estado"];
               }
               if(Hash::check($request->passwordAdmin,$pass)) // && verificarEstado ($est)
                {
                    $user->ci = $request->ci;
                    $user->nombre = $request->nombre;
                    $user->apellido = $request->apellido;
                    $user->telefono = $request->telefono;
                    $user->email = $request->email;
                    $user->login = $request->login;
                    if($request->hasFile('foto'))
                    {
                        if($user->foto != 'users/foto.jpg')
                        {
                            Storage::delete('public/'.$user->foto);
                        }
                        $user->photo = $request->file('foto')->store('users','public');
                    }
                   
                    if(($request->password != "") && ($request->password_confirmation != "") && ($request->password_confirmation == $request->password)){
                        $user->password = Hash::make($request->password);
                    }
                  $user->user = session('idSession');
                    $user->update();
                    DB::commit();
                    return back()->with('success','Datos actualizados correctamente');
               }
            }
        }
        catch (\Exception $e) 
        {
            DB::rollBack();
        }
        return Redirect::route('user.index');
    }

    public function destroy($id){    
        try {
            DB::beginTransaction();
            $user = new User;
            $user = User::findOrFail($id,['id','estado']);
            if(verificarEstado($user->status)){
                $user->status = 0;
            }else{
                $user->status = 1;
            }
            $user->save();
            DB::commit();
            return Redirect::route('user.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }
    
    public function show(){
        
    }
}