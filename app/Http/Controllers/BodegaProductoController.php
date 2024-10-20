<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BodegaProductoController extends Controller
{
    public function index($bodegaId)
    {
        return view('bodegas.index', compact('bodegaId'));
    }
}
