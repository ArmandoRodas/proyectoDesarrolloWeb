<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function index()
    {
        return view('subcategorias.index');
    }
}
