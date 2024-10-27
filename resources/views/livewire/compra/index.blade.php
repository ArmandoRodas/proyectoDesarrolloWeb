<div>
    <div class="card">
        <div class="card-body">
            {{-- Manejo de mensajes --}}
            @if (session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label for="codigo_proveedor">Codigo</label>
                    <input
                        type="text"
                        class="form-control"
                        id="codigo_proveedor"
                        wire:model.live='codigo_proveedor'
                        placeholder="Codigo proveedor"
                        readonly
                    >
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombre_proveedor">Proveedor</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nombre_proveedor"
                        wire:model='searchTermProveedor'
                        wire:click='toggleDropdownProveedor'
                        placeholder="Buscar"
                        {{ $subtotal > 0 ? 'disabled' : '' }}
                    >
                    @if ($showDropdownProveedor && (strlen($searchTermProveedor) > 2 || count($proveedores) > 0))
                        <ul class="bg-white border">
                            @forelse ($proveedores as $p)
                                <li
                                    class="px-4 py-2 cursor-pointer"
                                    wire:click='selectProveedor({{ $p->id_persona }})'
                                >
                                    {{ $p->codigo_persona}} {{ $p->nombre_persona }} {{ $p->nit_persona }}
                                </li>
                            @empty
                                <li class="px-4 py-2">Sin resultados</li>
                            @endforelse
                        </ul>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <label for="id_metodo_pago">Metodo de pago</label>
                    <select
                        id="id_metodo_pago"
                        wire:model="id_metodo_pago"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($metodosPagos as $metodoPago)
                            <option value="{{ $metodoPago->id_metodo_pago }}">{{ $metodoPago->nombre_metodo_pago }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="id_tipoCompra">Tipo de compra</label>
                    <select
                        id="id_tipoCompra"
                        wire:model.live="id_tipoCompra"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($tipoCompras as $tipoCompra)
                            <option value="{{ $tipoCompra->id_tipoCompra }}">{{ $tipoCompra->nombre_tipoCompra }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($id_tipoCompra == 2)
                    <div class="col-md-2 mb-3">
                        <label for="dias_credito">Dias credito</label>
                        <input
                            type="text"
                            class="form-control"
                            id="dias_credito"
                            wire:model="dias_credito"
                            pattern="^\d*$"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                @endif
                <div class="col-md-2 mb-3">
                    <label for="id_bodega">Bodega</label>
                    <select
                        id="id_bodega"
                        wire:model.live="id_bodega"
                        class="form-control"
                    >
                        <option value="">--Seleccione--</option>
                        @foreach ($bodegas as $bodega)
                            <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="descripcion_compra">Descripcion de compra</label>
                    <input
                        type="text"
                        class="form-control"
                        id="descripcion_compra"
                        wire:model='descripcion_compra'
                        placeholder="Descripcion de compra"
                        style="width: 100%; font-size: 1.2em; padding: 10px;"
                    >
                </div>
                <div class="col-md-2 mb-3">
                    <label for="referencia">Referencia</label>
                    <input
                        type="text"
                        class="form-control"
                        id="referencia"
                        wire:model='referencia'
                        placeholder="Referencia"
                        style="width: 100%; font-size: 1.2em; padding: 10px;"
                    >
                </div>
            </div>
            @if ($subtotal > 0)
                <button
                    class="btn btn-sm btn-success"
                    wire:click="finalizarCompra"
                >
                    Finalizar Venta
                </button>
            @endif
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">
                Detalle
            </h3>
        </div>
        <div class="card-body">
            {{-- BUSCAR PRODUCTO --}}
            <div class="mb-3">
                <label for="buscarProducto">Producto</label>
                <input
                    type="text"
                    class="form-control"
                    id="buscarProducto"
                    wire:model.live='searchTermProducto'
                    wire:click='toggleDropdownProducto'
                    placeholder="Buscar Producto"
                    {{ $searchTermProveedor ? '' : 'disabled' }}
                >
                {{-- Lista deplegable de Productos --}}
                @if ($showDropdownProducto && (strlen($searchTermProducto) > 2 || count($productos) > 0))
                    <ul class="bg-white border">
                        @forelse ($productos as $producto)
                            <li
                                class="px-4 py-2 cursor-pointer"
                                wire:click='selectProducto({{ $producto->id_producto }})'
                            >
                                {{ $producto->sku_producto }} - {{ $producto->nombre_producto }}
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
                        <td>Precio unitario</td>
                        <td>Subtotal</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cartItems as $p)
                        <tr>
                            <td>{{ $p['options']['sku'] }}</td>
                            <td>{{ $p['name'] }}</td>
                            <td>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="cantidad_compra_detalle"
                                    name="cantidad_compra_detalle"
                                    wire:input="actualizarQtyProducto('{{ $p['rowId'] }}', $event.target.value)"
                                    value="{{ $p['qty'] }}"
                                    pattern="^\d*$"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >
                            </td>
                            <td>Q.{{ $p['price'] }}</td>
                            <td>Q.{{ $p['subtotal'] }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="eliminarProducto('{{ $p['rowId'] }}')"
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
