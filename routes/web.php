<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MessageController;
/*

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[LoginController::class,'index'])->name('root');
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('email', [AuthController::class, 'email'])->name('email');
Route::post('enlace', [AuthController::class, 'enlace'])->name('enlace');
Route::get('clave/{token}', [AuthController::class, 'clave'])->name('clave');
Route::post('cambiar', [AuthController::class, 'cambiar'])->name('cambiar');


//menu
Route::get('/menu',[MenuController::class,'index'])->name('menu')->middleware('camouflage');
Route::post('/menu/session',[MenuController::class,'session'])->name('session')->middleware('camouflage');
Route::post('/menu/messages',[MenuController::class,'messages'])->name('messages')->middleware('camouflage');
Route::post('/menu/searchClient',[MenuController::class,'searchClient'])->name('searchClient');
Route::post('/menu/searchSupplier',[MenuController::class,'searchSupplier'])->name('searchSupplier');
//usuario
Route::resource('/user',UserController::class)->middleware('camouflage');
//caja
Route::resource('/cash',CashController::class)->middleware('camouflage');
//producto
Route::resource('/product',ProductController::class)->middleware('camouflage');
//categoria
Route::resource('/category',CategoryController::class)->middleware('camouflage');
//clientes
Route::resource('/client',ClientController::class)->middleware('camouflage');
//proveedores
Route::resource('/supplier',SupplierController::class)->middleware('camouflage');
//venta
Route::get('/sale/{id}',[SaleController::class,'index'])->name('sale.index')->middleware('camouflage');
Route::post('/sale',[SaleController::class,'store'])->name('sale.store')->middleware('camouflage');
Route::get('/sale/{id}/show',[SaleController::class,'show'])->name('sale.show')->middleware('camouflage');
Route::get('/sale/{id}/print',[SaleController::class,'print'])->name('sale.print')->middleware('camouflage');
Route::get('/sale/{id}/print80',[SaleController::class,'print80'])->name('sale.print80')->middleware('camouflage');
Route::get('/sale/{id}/destroy',[SaleController::class,'destroy'])->name('sale.destroy')->middleware('camouflage');
Route::post('/sale/debt',[SaleController::class,'debt'])->name('sale.debt')->middleware('camouflage');
//compra
Route::get('/buy/{id}',[BuyController::class,'index'])->name('buy.index')->middleware('camouflage');
Route::post('/buy',[BuyController::class,'store'])->name('buy.store')->middleware('camouflage');
Route::get('/buy/{id}/show',[BuyController::class,'show'])->name('buy.show')->middleware('camouflage');
Route::get('/buy/{id}/print',[BuyController::class,'print'])->name('buy.print')->middleware('camouflage');
Route::get('/buy/{id}/print80',[BuyController::class,'print80'])->name('buy.print80')->middleware('camouflage');
//movimientos
Route::get('/movement',[MovementController::class,'index'])->name('movement.index')->middleware('camouflage');
Route::get('/movement/create',[MovementController::class,'create'])->name('movement.create')->middleware('camouflage');
Route::post('/movement',[MovementController::class,'store'])->name('movement.store')->middleware('camouflage');
Route::post('/movement/empty',[MovementController::class,'empty'])->name('movement.empty')->middleware('camouflage');
//reportes
Route::get('/report/sales',[ReportController::class,'sales'])->name('report.sales')->middleware('camouflage');
Route::post('/report/sale',[ReportController::class,'sale'])->name('report.sale')->middleware('camouflage');
Route::get('/report/deptors',[ReportController::class,'deptors'])->name('report.deptors')->middleware('camouflage');
Route::get('/report/sales/{date}',[ReportController::class,'reportsales'])->name('report.reportsales')->middleware('camouflage');
Route::post('/report/printsales',[ReportController::class,'printsales'])->name('report.printsales')->middleware('camouflage');
Route::post('/report/bottles',[ReportController::class,'bottles'])->name('report.bottles')->middleware('camouflage');
Route::get('/report/catalog',[ReportController::class,'catalog'])->name('report.catalog')->middleware('camouflage');
//social
Route::get('/message/{id}',[MessageController::class,'index'])->name('message.index')->middleware('camouflage');
Route::post('/message',[MessageController::class,'store'])->name('message.store')->middleware('camouflage');
Route::get('/message/{id}/show',[MessageController::class,'show'])->name('message.show')->middleware('camouflage');
Route::get('/message',[MessageController::class,'center'])->name('message.center')->middleware('camouflage');