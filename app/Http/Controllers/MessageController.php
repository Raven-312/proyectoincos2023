<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{
    public function index($id){
        if(session('accessSession') != 'root'){
            return view('errors.403');
        }else{            
            $data['to'] = User::findOrFail($id,['id AS ID','name AS nombres','lastname AS apellidos','status AS estado']);
            $data['from'] = User::findOrFail(session('idSession'),['id AS ID','name AS nombres','lastname AS apellidos']);
            if(verificarEstado($data['to']->estado)){
                return view('social.new_message',$data);
            }
            return Redirect::route('user.index');
        }
    }
    public function store(Request $request){
        $request->validate([
            "subject" => "bail | required | max:100",
            "message" => " bail | required | max:255",
            "password" => " bail | required"
        ],[
            "subject.required" => "No debe estar vacio",
            "name.max" => "Máximo 100 caracteres",
            "subject.required" => "No debe estar vacio",
            "subject.max" => "Máximo 255 caracteres",
            "password.required" => "La contraseña es requerida",
        ]);
        try {
            if(session('accessSession') != 'root'){
                return view('errors.403');
            }else{
                DB::beginTransaction();
                $messaje = new Message;
                $admin = User::select('id','password','status')
                    ->where('login',session('usernameSession'))
                    ->get();
                $admin->toJson();
                if(count($admin) > 0){
                    foreach ($admin as $row) {
                        $pass = $row["password"];
                        $est = $row["status"];
                    }
                    if(Hash::check($request->password,$pass) && verificarEstado($est)){
                        $messaje->to = $request->to;
                        $messaje->from = session('idSession');
                        $messaje->subject = $request->subject;
                        $messaje->message = $request->message;
                        $messaje->type = $request->important;
                        $messaje->save();
                        DB::commit();
                        return back()->with('success','Mensaje enviado correctamente');
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
        return Redirect::route('user.index');
    }
    public function show($id){
    try {
        DB::beginTransaction();
        $mail = Message::findOrFail($id);
        if($mail->status == 0){
            $mail->status = 1;
            $mail->update();
            DB::commit();
        }
        $data['message'] = Message::getMessage($id);
        return view('social.view_message',$data);
    }catch (\Exception $e) {
        DB::rollBack();
    }
    return Redirect::route('user.index');
    }
    public function center(){
        $data['messages'] = Message::getAllMessages(session('idSession'));
        $data['con'] = count($data['messages']);
        return view('social.center_message',$data);
    }
}
