@extends('adminlte::page')

@section('title', 'Clientes | Facturas por Cobrar')

@section('content_header')
    <h1>Facturas por Cobrar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form role="form" action="{{ route('pagoFactura.store', $cxc) }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="nombre_persona">Cliente</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nombre_persona"
                            name="nombre_persona" 
                            value="{{ $cxc->cliente->nombre_persona }}" 
                            readonly
                        >
                    </div>
                    <div class="col-6">
                        <label>Factura</label>
                        <input 
                            name="venta_id" 
                            id="venta_id" 
                            type="text" 
                            class="form-control" 
                            value="{{ $cxc->venta->tipoDocumento->nombre_tipoDocumento}}: {{ $cxc->venta->documento_venta }}" 
                            readonly>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <label>Monto total de la factura (Q)</label>
                        <input 
                            name="monto_cxc" 
                            id="monto_cxc" 
                            type="text" 
                            class="form-control" 
                            value="{{ $cxc->monto_cxc}}" 
                            readonly
                        >
                    </div>
                    <div class="col-6">
                        <label for="saldo_pendiente_cxc">Saldo pendiente (Q)</label>
                        <input 
                            name="saldo_pendiente_cxc" 
                            id="saldo_pendiente_cxc" 
                            type="text" class="form-control" 
                            value="{{ $cxc->saldo_pendiente_cxc }}"
                            readonly
                        >
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="dias_credito">Días de crédito</label>
                        <input 
                            name="dias_credito" 
                            id="dias_credito" 
                            type="number"
                            class="form-control"
                            value="{{ $cxc->dias_credito }}"
                            readonly
                        >
                    </div>
                    <div class="col-6">
                        <label for="fecha_vencimiento_cxc">Fecha vencimiento</label>
                        <input 
                            name="fecha_vencimiento_cxc"
                            id="fecha_vencimiento_cxc"
                            type="text" class="form-control"
                            value="{{ date('d-m-Y', strtotime($cxc->fecha_vencimiento_cxc)) }}"
                            readonly
                        >
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="monto_abonado">Monto a abonar</label>
                        <input name="monto_abonado" id="monto_abonado" type="number" step="0.01" class="form-control" required>

                        <input name="cxc_id" id="cxc_id" type="hidden" value="{{ $cxc->id }}">
                    </div>
                </div>
                
                <button
                    type="submit"
                    class="btn btn-primary rounded-pill block"
                >
                    Crear pago
                </button>
            </form>
        </div>
    </div>
@stop
