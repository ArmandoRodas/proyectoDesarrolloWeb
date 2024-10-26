<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- ENCABEZADO --}}
                <div class="col-md-2 mb-3">
                    <label for="codigo_cliente">Codigo Cliente</label>
                    <input 
                        type="text"
                        class="form-control"
                        id="codigo_cliente"
                        wire:model='codigo_cliente'
                        placeholder="Codigo Cliente"
                        readonly
                    >
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombre_cliente">Cliente *</label>
                    <input 
                        type="text"
                        class="form-control"    
                        id="nombre_cliente"
                        wire:model.live='searchTermCliente'
                        wire:click='toggleDropdownCliente'
                        placeholder="Buscar Cliente"
                    >
                    {{-- Lista deplegable de Clientes --}}
                    @if ($showDropdownCliente && (strlen($searchTermCliente) > 2 || count($clientes) > 0))
                        <ul class="bg-white border">
                            @forelse ($clientes as $cliente)
                                <li
                                    class="px-4 py-2 cursor-pointer"
                                    wire:click='selectCliente({{ $cliente->id_persona }})'
                                >
                                    {{ $cliente->nombre_persona }} {{ $cliente->nit_persona }}
                                </li>
                            @empty
                                <li class="px-4 py-2">Sin resultados</li>
                            @endforelse
                        </ul>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <label for="nombre_caja">Caja *</label>
                    <input type="text"
                        id="nombre_caja"
                        name='nombre_caja'
                        class="form-control"
                        value="{{ Auth::user()->caja->nombre_caja ?? null }}"
                        readonly
                    >
                </div>
                <div class="col-md-2 mb-3">
                    <label for="id_tipo_documento">Tipo de documento *</label>
                    <select 
                        name="id_tipo_documento" 
                        id="id_tipo_documento"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($tipoDocumentos as $doc)
                            <option value="{{ $doc->id_documento }}">{{ $doc->nombre_tipoDocumento }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="id_medio_pago">Metodo de pago *</label>
                    <select 
                        name="id_medio_pago" 
                        id="id_medio_pago"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($metodosPagos as $metodoPago)
                            <option value="{{ $metodoPago->id_metodo_pago }}">{{ $metodoPago->nombre_metodo_pago }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="id_tipoVenta">Tipo de venta *</label>
                    <select 
                        name="id_tipoVenta" 
                        id="id_tipoVenta"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($tipoVentas as $tipoVenta)
                            <option value="{{ $tipoVenta->id_tipoVenta }}">{{ $tipoVenta->nombre_tipoVenta }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- FINALIZAR VENTA --}}
            @if ($subtotal > 0)
                <button
                    class="btn btn-success"
                >
                    Finalizar Venta
                </button>
            @endif
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">
                Detalle venta
            </h3>
        </div>
        <div class="card-body">
            {{-- BUSCAR PRODUCTO --}}
            <div class="mb-3">
                <label for="buscarProducto">Producto *</label>
                <input 
                    type="text"
                    class="form-control"    
                    id="buscarProducto"
                    wire:model.live='searchTermProducto'
                    wire:click='toggleDropdownProducto'
                    placeholder="Buscar Producto"
                    {{ $searchTermCliente ? '' : 'disabled' }}
                >
                {{-- Lista deplegable de Productos --}}
                @if ($showDropdownProducto && (strlen($searchTermProducto) > 2 || count($productos) > 0))
                    <ul class="bg-white border">
                        @forelse ($productos as $producto)
                            <li
                                class="px-4 py-2 cursor-pointer"
                                wire:click='selectProducto({{ $producto->id_producto }})'
                            >
                                {{ $producto->sku_producto }} : {{ $producto->nombre_producto }}
                            </li>
                        @empty
                            <li class="px-4 py-2">Sin resultados</li>
                        @endforelse
                    </ul>
                @endif
            </div>
            <table class="table table-bordeless" cellspacing="0" width="100%">
                <thead class="table-dark">
                    <tr>
                        <td>Codigo</td>
                        <td>Descripcion</td>
                        <td>Unidades</td>
                        <td>Bodega</td>
                        <td>Precio unitario</td>
                        <td>Subtotal</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cartItems as $venta)
                        <tr>
                            <td>{{ $venta['options']['sku_producto'] }}</td>
                            <td>{{ $venta['name'] }}</td>
                            <td>
                                <input 
                                    type="text"
                                    class="form-control"
                                    id="cantidad_venta_detalle"
                                    name="cantidad_venta_detalle"
                                    wire:input="actualizarQtyProducto('{{ $venta['rowId'] }}', $event.target.value)"
                                    value="{{ $venta['qty'] }}"
                                    pattern="^\d*$"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >
                            </td>
                            <td>{{ $venta['options']['nombre_bodega'] }}</td>
                            <td>Q.{{ $venta['price'] }}</td>
                            <td>Q.{{ $venta['subtotal'] }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="eliminarProducto('{{ $venta['rowId'] }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Sin resultados</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($subtotal > 0)
                    <tfoot>
                        <tr>
                            <th colspan="5" scope="row" class="text-right">Subtotal</th>
                            <td>Q.{{ $subtotal }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
