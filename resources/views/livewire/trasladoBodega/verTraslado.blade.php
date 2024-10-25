<div>
    <input type="text" wire:model="search" class="form-control mb-3" placeholder="Buscar traslados...">

    <!-- Tabla de traslados -->
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Documento</th>
            <th>Bodega Origen</th>
            <th>Bodega Destino</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Fecha Traslado</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($traslados as $traslado)
            <tr>
                <td>{{ $traslado->documento_traslado }}</td>
                <td>{{ $traslado->bodegaOrigen->nombre_bodega ?? 'N/A' }}</td>
                <td>{{ $traslado->bodegaDestino->nombre_bodega ?? 'N/A' }}</td>
                <td>{{ $traslado->detalles->producto->nombre_producto}}</td>
                <td>{{ $traslado->detalles->cantidad_trasladar}}</td>
                <td>{{ $traslado->fecha_traslado }}</td>
                <td>{{ $traslado->descripcion_traslado }}</td>
                <td>
                    {{--<button wire:click="edit({{ $traslado->id_traslado }})" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editTrasladoModal">
                        Editar
                    </button>--}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No hay traslados registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $traslados->links() }}

    <!-- Modal de edición -->
    <div wire:ignore.self class="modal fade" id="editTrasladoModal" tabindex="-1" role="dialog" aria-labelledby="editTrasladoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrasladoModalLabel">Editar Traslado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de edición -->
                    <div class="form-group">
                        <label for="documento_traslado">Documento Traslado</label>
                        <input type="text" wire:model="documento_traslado" class="form-control">
                        @error('documento_traslado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_bodega_origen">Bodega Origen</label>
                        <select wire:model="id_bodega_origen" class="form-control">
                            <option value="">Selecciona Bodega Origen</option>
                            @foreach($bodegas as $bodega)
                                <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
                            @endforeach
                        </select>
                        @error('id_bodega_origen') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_bodega_destino">Bodega Destino</label>
                        <select wire:model="id_bodega_destino" class="form-control">
                            <option value="">Selecciona Bodega Destino</option>
                            @foreach($bodegas as $bodega)
                                <option value="{{ $bodega->id_bodega }}">{{ $bodega->nombre_bodega }}</option>
                            @endforeach
                        </select>
                        @error('id_bodega_destino') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="descripcion_traslado">Descripción Traslado</label>
                        <textarea wire:model="descripcion_traslado" class="form-control"></textarea>
                        @error('descripcion_traslado') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" data-dismiss="modal" wire:click='updateTraslado'>Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>
