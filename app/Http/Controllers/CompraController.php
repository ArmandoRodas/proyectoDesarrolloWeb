<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CompraController extends Controller
{
    public function index()
    {
        Cart::instance('compras')->destroy();
        return view('compra.index');
    }
}
