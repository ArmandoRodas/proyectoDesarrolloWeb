<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {
        return view('cajas.index');
    }

    public function aperturaCaja()
    {
        return view('cajas.aperturaCaja');
    }

    public function corteCaja()
    {
        return view('cajas.corteCaja');
    }
}
