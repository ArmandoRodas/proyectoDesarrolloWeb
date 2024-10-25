<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BodegaProductoController extends Controller
{
    public function index()
    {
        return view('bodegas.index');
    }

    public function create()
    {
        return view('bodegas.create');
    }
}
