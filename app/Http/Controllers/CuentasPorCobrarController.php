<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\HistorialCXC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentasPorCobrarController extends Controller
{
    public function facturasCobrar()
    {
        return view('pagos-cobros.clientes.facturasCobrar');
    }

    public function historialCobros()
    {
        return view('pagos-cobros.clientes.historialCobros');
    }

    public function pagoFactura(CuentaPorCobrar $cxc)
    {
        return view('pagos-cobros.clientes.pagoFactura', [
            'cxc' => $cxc
        ]);
    }

    public function pagoFacturaStore(Request $request, CuentaPorCobrar $cxc)
    {
        DB::beginTransaction();
        
        $historial_cxc = new HistorialCXC();

        // VALIDAR SI EL MONTO TOTAL ES MAYOR O IGUAL A MONTO ABONADO QUE SE PUEDA REALIZAR LA VENTA  
        if($request->saldo_pendiente_cxc >= $request->monto_abonado && $request->monto_abonado>0){
            try {
                // Actualizar la cuenta por cobrar
                $cxc->saldo_pendiente_cxc = $request->saldo_pendiente_cxc - $request->monto_abonado;

                if($cxc->saldo_pendiente_cxc<=0){
                    $cxc->id_estado = 5;
                }else{
                    $cxc->id_estado = 6;
                }
                $cxc->save();

                // Almacenar el historial del pago
                $historial_cxc->id_cxc = $cxc->id_cxc;
                $historial_cxc->monto_pagado_historial_cxc = $request->monto_abonado;
                $historial_cxc->referencia_pago_historial_cxc = 'Pago para la factura: '.$cxc->venta->documento_venta;
                $historial_cxc->save();

                DB::commit();

                session()->flash('success', 'El pago se realizo correctamente, saldo pendiente: Q.'.$cxc->saldo_pendiente_cxc . ' - ' . $cxc->venta->tipoDocumento->nombre_tipoDocumento . ':' . $cxc->venta->documento_venta);

                return to_route('facturasCobrar');

            } catch (\Exception $e) {
                DB::rollBack();

                return back()->with('error' ,'No se pudo realizar el pago: '. $e->getMessage());
            }
        }else{
            return back()->with('error','El monto abonado excede al saldo pendiente, monto abonado: Q.'. $request->monto_abonado. ', saldo pendiente: Q.'.$request->saldo_pendiente_cxc);
        }
    }
}
