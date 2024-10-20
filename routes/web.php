<?php

use App\Http\Controllers\BodegaProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\TrasladoController;
use App\Livewire\bodega\BodegasInventario;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Clientes
Route::get('/clientes', [ClienteController::class, 'index'])->middleware('auth')->name('clientes.index');

//Proveedores
Route::get('/proveedores', [ProveedoresController::class, 'index'])->middleware('auth')->name('proveedores.index');

//Productos
Route::get('/productos', [ProductoController::class, 'index'])->middleware('auth')->name('productos.index');

//Bodegas
Route::get('/bodegas/{bodegaId}', [BodegaProductoController::class, 'index'])->middleware('auth')->name('bodegas.index');

//Traslados
Route::get('/traslados', [TrasladoController::class, 'index'])->middleware('auth')->name('traslados.indTrasladoController');
