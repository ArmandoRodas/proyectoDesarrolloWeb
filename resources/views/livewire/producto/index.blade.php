<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Producto
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
                        {{ $producto_id ? 'Editar Producto' : 'Crear Producto' }}
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
                    <div>
                        <label for="sk_producto">SKU del Producto</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='sk_producto'
                            id="sk_producto"
                            value="{{ old('sk_producto') }}"
                        >
                    </div>
                    <div>
                        <label for="cod_barra">Código de Barra</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='cod_barra'
                            id="cod_barra"
                            value="{{ old('cod_barra') }}"
                        >
                    </div>
                    <div>
                        <label for="nombre_producto">Nombre del Producto</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='nombre_producto'
                            id="nombre_producto"
                            value="{{ old('nombre_producto') }}"
                        >
                    </div>
                    <div>
                        <label for="descripcion_producto">Descripción del Producto</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='descripcion_producto'
                            id="descripcion_producto"
                            value="{{ old('descripcion_producto') }}"
                        >
                    </div>
                    <div>
                        <label for="precio_compra">Precio de Compra</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='precio_compra'
                            id="precio_compra"
                            value="{{ old('precio_compra') }}"
                        >
                    </div>
                    <div>
                        <label for="precio_venta">Precio de Venta</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='precio_venta'
                            id="precio_venta"
                            value="{{ old('precio_venta') }}"
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
                            wire:click='guardarProducto'
                        >
                            {{ $producto_id ? 'Actualizar Producto' : 'Crear Producto' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar productos">

        <table class="table">
            <thead class="table-dark">
            <tr>
                <td>SKU Producto</td>
                <td>Nombre Producto</td>
                <td>Código de Barra</td>
                <td>Precio Venta</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>{{ $producto->sk_producto }}</td>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td>{{ $producto->cod_barra }}</td>
                    <td>{{ $producto->precio_venta }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarProducto({{ $producto->id }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Sin resultados</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    </div>
</div>
