<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function nuevoDocumento()
    {
        Cart::instance('ventas')->destroy();
        
        return view('ventas.nuevoDocumento');
    }

    public function consultaDocumento()
    {
        return view('ventas.consultaDocumento');
    }
}
