<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function index()
    {
        return view('municipio.index');
    }
}
