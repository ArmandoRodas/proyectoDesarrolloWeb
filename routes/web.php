<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;
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

// Empresa
Route::get('/parametrizaciones-generales/empresa', [EmpresaController::class, 'index'])->middleware('auth')->name('empresa.index');

//proveedores
Route::get('/Proveedores', [ProveedoresController::class, 'index'])->middleware('auth')->name('proveedores.index');

//categoria
Route::get('/categorias', [CategoriaController::class, 'index'])->middleware('auth')->name('categorias.index');

//subcategoria
Route::get('/subcategorias', [SubcategoriaController::class, 'index'])->middleware('auth')->name('subcategorias.index');

//Pais 
Route::get('/paises', [PaisController::class, 'index'])->middleware('auth')->name('paises.index');

//Departamento
Route::get('/departamentos', [DepartamentoController::class, 'index'])->middleware('auth')->name('departamentos.index');

//Municipio
Route::get('/municipios', [MunicipioController::class, 'index'])->middleware('auth')->name('municipios.index');