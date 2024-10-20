<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Bodega
    </button>

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

{{--
    <!-- Modal -->
    <div
        class="modal fade"
        id="staticBackdrop"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
        wire:ignore.self
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ $cliente_id ? 'Editar Cliente' : 'Crear Cliente' }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        wire:click='resetInput'
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    --}}{{-- <form wire:submit="guardarCliente"> --}}{{--
                        <div>
                            <label for="codigo_cliente">Codigo del cliente</label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model='codigo_cliente'
                                id="codigo_cliente"
                                value="{{ old('codigo_cliente') }}"
                            >
                        </div>
                        <div>
                            <label for="nombre_cliente">Nombre del cliente</label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model='nombre_cliente'
                                id="nombre_cliente"
                                value="{{ old('nombre_cliente') }}"
                            >
                        </div>
                        <div>
                            <label for="nit_cliente">Nit del cliente</label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model='nit_cliente'
                                id="nit_cliente"
                                value="{{ old('nit_cliente') }}"
                            >
                        </div>
                        <div>
                            <label for="direccion_cliente">Dirección del cliente</label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model='direccion_cliente'
                                id="direccion_cliente"
                                value="{{ old('direccion_cliente') }}"
                            >
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                                wire:click='resetInput'
                            >
                                Cerrar
                            </button>
                            <button
                                type="submit"
                                class="btn btn-success"
                                data-dismiss="modal"
                                wire:click='guardarCliente'
                            >
                                {{ $cliente_id ? 'Actualizar Cliente' : 'Crear Cliente' }}
                            </button>
                        </div>
                    --}}{{-- </form> --}}{{--
                </div>
            </div>
        </div>
    </div>

    --}}

    <div class="mt-3">
        <h1>INVENTARIO DE BODEGA: {{$nombreBodega}}</h1>
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar clientes">

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Producto</td>
                    <td>Stock Actual</td>
                    <td>Stock Mínimo</td>
                    <td>Stock Máximo</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($productosEnBodega as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre_producto }}</td>
                        <td>{{ $detalle->stock_producto }}</td>
                        <td>{{ $detalle->stock_min_producto }}</td>
                        <td>{{ $detalle->stock_max_producto }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarCliente({{ $detalle->id }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
{{--            {{ $productosEnBodega->links() }}--}}
        </div>
    </div>
</div>
