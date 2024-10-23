<div>
    @if (session('error'))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-3">
        <h5>INVENTARIO DE BODEGA: {{$nombreBodega}}</h5>

        <div class="row">
            <!-- Selector de bodegas -->
            <div class="col-sm-8">
                <select class="form-control mb-3" wire:change="cambiarBodega($event.target.value)">
                    <option value="">Selecciona una bodega</option>
                    @foreach ($bodegas as $bodega)
                        <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <a href="{{ route('traslados.index') }}" class="btn btn-success">Realizar Nuevo Traslado</a>
            </div>
        </div>

        <!-- Input de búsqueda -->
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar Productos">

        <table class="table">
            <thead class="table-dark">
            <tr>
                <td>Producto</td>
                <td>Stock Actual</td>
                <td>Stock Mínimo</td>
                <td>Stock Máximo</td>
            </tr>
            </thead>
            <tbody>
            @forelse ($productosEnBodega as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre_producto }}</td>
                    <td>{{ $detalle->stock_producto }}</td>
                    <td>{{ $detalle->stock_min_producto }}</td>
                    <td>{{ $detalle->stock_max_producto }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Sin resultados</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
{{--             {{ $productosEnBodega->links() }}--}}
        </div>
    </div>
</div>
