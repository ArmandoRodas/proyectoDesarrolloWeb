@extends('adminlte::page')

@section('title', 'Ventas | Consulta documento')

@section('content_header')
    <h1>Detalle</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <label for="fecha_venta">Fecha:</label>
                    {{ date('d-m-Y H:i:s', strtotime($venta->created_at))}}
                </li>
                <li>
                    <label for="nombre_cliente">Cliente:</label>
                    {{ $venta->cliente->nombre_persona }}
                </li>
                <li>
                    <label for="total_venta">Total venta:</label>
                    Q.{{ $venta->total_venta }}
                </li>
                <li>
                    <label for="tipo_venta">Tipo venta:</label>
                    {{ $venta->tipoVenta->nombre_tipoVenta}}
                </li>
                <li>
                    <label for="metodo_pago">Metodo pago:</label>
                    {{ $venta->metodoPago->nombre_metodo_pago}}
                </li>
                <li>
                    <label for="usuario">Usuario:</label>
                    {{ $venta->usuario->name}}
                </li>
            </ul>

            <div class="mt-3">
                <table class="table mt-3">
                    <thead class="table-dark">
                        <tr>
                            <td>Codigo producto</td>
                            <td>Descripcion producto</td>
                            <td>Unidades</td>
                            <td>Precio unitario</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventaDetalle as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->sku_producto }}</td>
                                <td>{{ $detalle->producto->descripcion_producto }}</td>
                                <td>{{ $detalle->cantidad_venta_detalle }}</td>
                                <td>Q.{{ $detalle->producto->precio_venta_producto }}</td>
                                <td>Q.{{ $detalle->subtotal_venta_detalle}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
