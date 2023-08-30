<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->has('idSession')) 
        {
            return Redirect::route('menu');
        }
        return view('general.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            "username" => ["bail","required",Rule::exists('usuarios','login')],
            "password" => "required"
        ],[
            "username.required" => "Porfavor, coloque su nombre de usuario",
            "username.exists" => "Usuario no identificado",
            "password.required" => "Porfavor, coloque su contraseña"
        ]);
        $user = User::select('id','password','login','estado','tipo','idFondos')
            ->where('login',$request->username)
            ->get();
        $user->toJson();
        if(count($user) > 0){
            foreach ($user as $row) 
            {
                $id = $row["id"];
                $pass = $row["password"];
                $est = $row["estado"];
                $username = $row["login"];
                $access = $row["tipo"];
                $cash = $row["idFondos"];
            }
            if(Hash::check($request->password,$pass) && verificarEstado($est))
            {
                session(['idSession' => $id]);
                session(['usernameSession' => $username]);
                session(['accessSession' => $access]);
                session(['cashSession' => $cash]);
            }
        }
        return Redirect::route('root');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return Redirect::route('root');
    }
}
