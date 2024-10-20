<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrasladoController extends Controller
{
    public function index()
    {
        return view('traslado.index');
    }
}
