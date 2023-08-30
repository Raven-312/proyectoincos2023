<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Cash;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class MovementController extends Controller
{
    public function index(){
        $data['list'] = Movement::getMovements();
        if(session('accessSession')== 'root'){
            $data['list2'] = Cash::select('id AS ID','code AS codigo','alias AS nombre','cash AS efectivo')
            ->where('status', 1)
            ->get();
        }else{
            $data['list2'] = DB::table('cashes AS C')
            ->join('users AS U', 'U.cash', '=', 'C.id')
            ->select('C.id AS ID','C.code AS codigo','C.alias AS nombre','C.cash AS efectivo','U.login')
            ->where('U.id', session('idSession'))
            ->where('C.status', 1)
            ->get();
        }
        return view('movements.list_movements',$data);
    }
    public function create(){
        $data['list'] = Cash::select('id AS ID','code AS codigo','alias AS nombre','cash AS efectivo')
            ->where('status', 1)
            ->get();
        return view('movements.new_movement',$data);
    }
    public function store(Request $request){
        $request->validate([
            "amount" => "bail | required | numeric | between:0,9999999",
            "description" => " bail | required | max:255",
        ],[        
            "amount.required" => "No debe estar vacio",
            "amount.between" => "Válido desde 0 hasta 9999999",
            "amount.numeric" => "Solo valores númericos",
            "description.required" => "No debe estar vacio",
            "description.max" => "Maximo 255 caracteres"
        ]);
        try {
            DB::beginTransaction();
            if($request->amount > 0){
                $movement = new Movement;
                $movement->amount = $request->amount;
                $movement->type = $request->type;
                $movement->description = $request->description;
                $movement->cash = $request->cash;
                $movement->user = session('idSession');
                $movement->save();
                DB::commit();
                $cash = new Cash;
                $cash = Cash::findOrFail($request->cash,['id','cash']);
                if($request->type == 0){
                    $res = (double)$cash->cash + (double)$request->amount;
                }else{
                    $res = (double)$cash->cash - (double)$request->amount;
                }
                $cash->cash = $res;
                $cash->update();
                DB::commit();
                return back()->with('success','Movimiento creado correctamente');
            }
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('movement.index');
    }
    public function empty(Request $request){
        try {
            DB::beginTransaction();
            $cash = new Cash;
            $cash = Cash::findOrFail($request->cash,['id','cash']);
            if($cash->cash > 0){
                $movement = new Movement;
                $movement->amount = $cash->cash;
                $movement->type = 1;
                $movement->description = "Retiro de efectivo del dia ".date("d-m-Y");
                $movement->cash = $request->cash;
                $movement->user = session('idSession');
                $movement->save();
                $res = (double)$cash->cash - (double)$cash->cash;
                $cash->cash = $res;
                $cash->update();
                DB::commit();
                DB::commit();
                return back()->with('success','Movimiento creado correctamente');
            }
        }catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
        return Redirect::route('movement.index');
    }
}
