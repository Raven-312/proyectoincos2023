<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(){
        $data['list'] = Category::all('id AS ID','name AS nombre','status AS estado','created_at AS fecha');
        return view('products.list_category',$data);
    }
    
    public function create(){
        return view('products.new_category');
    }

    public function store(Request $request){
        $request->validate([
            "name" => "required | max:50",
        ],[            
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres"
        ]);
        try {
            DB::beginTransaction();
            $category = new Category;
            $category->name = $request->name;
            $category->user = session('idSession');
            $category->save();
            DB::commit();
            return back()->with('success',$request->name .' creada correctamente');
            }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('category.index');
    }

    public function edit($id){
        $category = Category::findOrFail($id,['id AS ID', 'name AS nombre']);
        return view('products.edit_category', compact('category'));
    }

    public function update(Request $request,$id){
        $request->validate([
            "name" => "required | max:50"
        ],[
            "name.required" => "No debe estar vacio",
            "name.max" => "Máximo 50 caracteres"
        ]);
        try {
            DB::beginTransaction();
            $category = new Category;
            $category = Category::findOrFail($id,['id','name','user']);
            $category->name = $request->name;
            $category->user = session('idSession');
            $category->update();
            DB::commit();
            return back()->with('success','Categoría modificada correctamente');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('category.index');
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            $category = new Category;
            $category = Category::findOrFail($id,['id','status']);
            if(verificarEstado($category->status)){
                $category->status = 0;
            }else{
                $category->status = 1;
            }
            $category->save();
            DB::commit();
            return Redirect::route('category.index');
        }catch (\Exception $e) {
            DB::rollBack();
        }
        return Redirect::route('category.index');
    }

    public function show(){

    }
}
