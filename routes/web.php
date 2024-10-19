<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProveedoresController;
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

// Emprea
Route::get('/parametrizaciones-generales/empresa', [EmpresaController::class, 'index'])->middleware('auth')->name('empresa.index');