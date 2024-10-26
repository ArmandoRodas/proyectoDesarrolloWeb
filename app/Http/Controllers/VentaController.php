<?php

namespace App\Http\Controllers;

use App\Models\AperturaCaja;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function nuevoDocumento()
    {
        // Obtener la caja por defecto del usuario
        $caja = Auth::user()->caja;

        if (!$caja) {
            session()->flash('error', 'No tienes una caja asignada.');
            return to_route('home');
        }

        // Verificar si la caja esta aperturada
        $aperturaCaja = AperturaCaja::where('id_caja', $caja->id_caja)
            ->where('id_estado', 3)
            ->first();

        if (!$aperturaCaja) {
            session()->flash('error', 'La caja predeterminada no ha sido aperturada.');
            return to_route('home');
        }

        Cart::instance('ventas')->destroy();
        
        return view('ventas.nuevoDocumento');
    }

    public function consultaDocumento()
    {
        return view('ventas.consultaDocumento');
    }

    public function consultaDocumentoDetalle(Venta $venta)
    {
        $ventaDetalle = VentaDetalle::where('id_venta', $venta->id_venta)->get();

        return view('ventas.detalleConsultaDocumento', [
            'venta' => $venta,
            'ventaDetalle' => $ventaDetalle
        ]);
    }
}
