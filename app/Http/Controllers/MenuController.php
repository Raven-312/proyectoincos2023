<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Message;
use App\Models\Client;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller
{
    public function index()
    {
        $data['earlings'] = Sale::getGains(date('Y'));
        $data['years'] = Sale::getYears();
        $data['materiales'] = Sale::getMaxProducts();
        return view('general.menu',$data);
       // return Redirect::route('client.index');
    }
    public function session(Request $request)
    {
        $data = User::select('ci AS CI','nombre AS nombres','apellido AS apellidos','telefono AS telefono','email AS correo','foto AS foto')
        ->where('login',$request->username)
        ->get();
        return $data->toJson();
    }
    public function messages(){
        $data = Message::getMessages(session('idSession'));
        return $data->toJson();
    }
    public function searchClient(Request $request)
    {
        $data = Client::select('id AS ID','nombre AS nombres','apellido AS apellidos','estado AS estado')
        ->where('ci',$request->ci)
        ->get();   
        return $data->toJson();
    }
    public function searchSupplier(Request $request)
    {
        $data = Supplier::select('id AS ID','nombre AS nombres','apellido AS apellidos','estado AS estado')
        ->where('ci',$request->ci)
        ->get();   
        return $data->toJson();
    }
}