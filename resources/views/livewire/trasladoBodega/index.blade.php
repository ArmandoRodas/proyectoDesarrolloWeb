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

    <!-- Mostrar productos solo si existen -->
    @if($productos && count($productos) > 0)
        <h3>Productos en la Bodega de Origen</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Stock Actual</th>
                <th>Cantidad a Trasladar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($productos as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre_producto }}</td>
                    <td>{{ $detalle->stock_producto }}</td>
                    <td>
                        <input type="number" wire:model="cantidadTraslado.{{ $detalle->producto->id }}" class="form-control" min="1" max="{{ $detalle->stock_producto }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No hay productos disponibles en la bodega seleccionada o no se ha seleccionado una bodega.</p>
    @endif

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
