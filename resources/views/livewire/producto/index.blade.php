<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
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
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="nombre_producto">Nombre del Producto</label>
                            <input type="text" class="form-control" wire:model='nombre_producto' id="nombre_producto" value="{{ old('nombre_producto') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="sku_producto">SKU del Producto</label>
                            <input type="text" class="form-control" wire:model='sku_producto' id="sku_producto" value="{{ old('sku_producto') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="cod_barra">Código de Barra</label>
                            <input type="text" class="form-control" wire:model='cod_barra' id="cod_barra" value="{{ old('cod_barra') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="marcas">Marca</label>
                            <select class="form-control" wire:model="id_marca" id="marcas">
                                <option value="">Selecciona una marca</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id_marca }}">{{ $marca->nombre_marca }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="subCategorias">Sub Categoría</label>
                            <select class="form-control" wire:model="id_subcategoria" id="subCategorias">
                                <option value="">Selecciona una Sub Categoria</option>
                                @foreach($subCategorias as $subCategoria)
                                    <option value="{{ $subCategoria->id_subcategoria }}">{{ $subCategoria->nombre_subcategoria }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label for="descripcion_producto">Descripción del Producto</label>
                            <textarea class="form-control" wire:model='descripcion_producto' id="descripcion_producto" rows="4">{{ old('descripcion_producto') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="precio_compra_producto">Precio de Compra</label>
                            <input type="number" class="form-control" wire:model='precio_compra_producto' id="precio_compra_producto" value="{{ old('precio_compra_producto') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="precio_venta_producto">Precio de Venta</label>
                            <input type="number" class="form-control" wire:model='precio_venta_producto' id="precio_venta_producto" value="{{ old('precio_venta_producto') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="vencimiento_producto">Fecha Vencimiento</label>
                            <input type="date" class="form-control" wire:model='vencimiento_producto' id="vencimiento_producto" value="{{ old('vencimiento_producto') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="estados">Estado</label>
                            <select class="form-control" wire:model="id_estado" id="estados">
                                <option value="">Selecciona un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Stock en Bodegas</h5>
                        @foreach($stocks as $index => $stock)
                            <div class="row mb-2" wire:key="stock-{{ $index }}">
                                <div class="col-sm-6">
                                    <label for="id_bodega_{{ $index }}">Bodega</label>
                                    <select class="form-control" wire:model="stocks.{{ $index }}.id_bodega" id="id_bodega_{{ $index }}" required>
                                        <option value="">Selecciona una bodega</option>
                                        @foreach($bodegas as $bodega)
                                            <option value="{{ $bodega->id_bodega }}">{{ $bodega->bodega->nombre_bodega }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="stock_producto_{{ $index }}">Stock</label>
                                    <input type="number" class="form-control" wire:model="stocks.{{ $index }}.stock_producto" id="stock_producto_{{ $index }}" required>
                                </div>
                                <div class="col-sm-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger" wire:click="removeStockRow({{ $index }})">-</button>
                                </div>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-primary" wire:click="addStockRow">Agregar Bodega</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetInput'>Cerrar</button>
                        <button type="button" class="btn btn-success" wire:click='guardarProducto' data-dismiss="modal">
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
                <td>Stock</td>
                <td>Precio Compra</td>
                <td>Precio Venta</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>{{ $producto->sku_producto }}</td>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td>{{ $producto->cod_barra }}</td>
                    <td>
                        @foreach ($producto->bodegaProducto as $bodega)
                            <div>Bodega: {{ $bodega->id_bodega }} - Stock: {{ $bodega->stock_producto }}</div>
                        @endforeach
                    </td>
                    <td>{{'Q. '. $producto->precio_compra_producto }}</td>
                    <td>{{'Q. '. $producto->precio_venta_producto }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarProducto({{ $producto->id_producto }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Sin resultados</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    </div>
</div>
