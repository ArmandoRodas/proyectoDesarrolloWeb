<div>
    <h1>Traslado de Productos entre Bodegas</h1>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Selección de Bodega de Origen -->
    <div class="form-group">
        <label for="bodegaOrigen">Bodega de Origen</label>
        <select wire:change="actualizarBodegaOrigen($event.target.value)" class="form-control">
            <option value="">Seleccionar Bodega de Origen</option>
            @foreach($bodegas as $bodega)
                <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
            @endforeach
        </select>
    </div>

    <div wire:loading>
        <p>Cargando productos...</p>
    </div>

    <div class="mt-3">
        <!-- Mostrar productos solo si existen -->
        @if(!$productosPaginados->isEmpty())
            <h5>Productos en la Bodega de Origen</h5>
            <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar productos">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>SKU Producto</th>
                    <th>Código de Barra</th>
                    <th>Stock Actual</th>
                    <th>Cantidad a Trasladar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productosPaginados as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre_producto }}</td>
                        <td>{{ $detalle->producto->sku_producto }}</td>
                        <td>{{ $detalle->producto->cod_barra }}</td>
                        <td>{{ $detalle->stock_producto }}</td>
                        <td>
                            <input type="number" wire:model="cantidadTraslado.{{ $detalle->producto->id_producto }}" class="form-control" min="1" max="{{ $detalle->stock_producto }}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No hay productos disponibles en la bodega seleccionada o no se ha seleccionado una bodega.</p>
        @endif

        @if($productosPaginados->hasPages())
            <div class="mt-3">
                {{ $productosPaginados->links() }}
            </div>
        @endif
    </div>

    <!-- Selección de Bodega de Destino -->
    <div class="form-group">
        <label for="bodegaDestino">Bodega de Destino</label>
        <select wire:model="bodegaDestino" class="form-control">
            <option value="">Seleccionar Bodega de Destino</option>
            @foreach($bodegas as $bodega)
                <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
            @endforeach
        </select>
    </div>

    <button wire:click="realizarTraslado" class="btn btn-primary">Realizar Traslado</button>
</div>
