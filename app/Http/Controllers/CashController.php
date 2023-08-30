<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CashController extends Controller
{
    public function index(){
        $data['list'] = Cash::all('id AS ID','code AS codigo','alias AS nombre','cash AS efectivo','status AS estado','created_at AS fecha');
        return view('cash.list_cash',$data);
    }
    
    public function create(){
        return view('cash.new_cash');
    }

    public function store(Request $request){
        $request->validate([
            "code" => ["bail","required","max:10",Rule::unique('cashes','code')],
            "alias" => "bail | required",
            "effective" => "bail | required | numeric | between:0,9999999"
        ],[        
            "code.unique" => "Ya existe este código",    
            "code.required" => "No debe estar vacio",
            "code.max" => "Maximo 10 caracteres",
            "alias.required" => "No debe estar vacio",
            "effective.required" => "No debe estar vacio",
            "effective.numeric" => "Solo números",
            "effective.between" => "Rango permitido entre 0 y 9999999"
        ]);
        try {
            DB::beginTransaction();
            $max = Cash::getCashMax();
            $cash = new Cash;
            $cash->id = ($max+1);
            $cash->code = $request->code;
            $cash->alias = $request->alias;
            if($request->effective != 0){
                $cash->cash = $request->effective;
            }
            $cash->user = session('idSession');
            $cash->save();
            if($request->effective != 0){
                $movement = new Movement;
                $movement->amount = $request->effective;
                $movement->type = 0;
                $movement->description = "Ingreso en efectivo de Bs ".$request->effective.' en la caja: '.$request->code;
                $movement->cash = $cash->id;
                $movement->user = session('idSession');
                $movement->save();
            }
            DB::commit();
            return back()->with('success',$request->alias .' creada correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('cash.index');
    }

    public function edit($id){
        $cash = Cash::findOrFail($id,['id AS ID','code AS codigo','alias AS nombre']);
        return view('cash.edit_cash', compact('cash'));
    }

    public function update(Request $request,$id){
        $request->validate([
            "alias" => "bail | required",
        ],[
            "alias.required" => "No debe estar vacio",
        ]);
        try {
            DB::beginTransaction();
            $cash = new Cash;
            $cash = Cash::findOrFail($id,['id','alias','user']);
            $cash->alias = $request->alias;
            $cash->user = session('idSession');
            $cash->update();
            DB::commit();
            return back()->with('success','Caja modificada correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('cash.index');
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            $cash = new Cash;
            $cash = Cash::findOrFail($id,['id','status']);
            if(verificarEstado($cash->status)){
                $cash->status = 0;
            }else{
                $cash->status = 1;
            }
            $cash->save();
            DB::commit();
            return Redirect::route('cash.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
