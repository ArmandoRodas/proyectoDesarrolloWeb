<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bodegaModal">
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

    <div
        class="modal fade"
        id="bodegaModal"
        data-backdrop="static"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="bodegaModalLabel"
        aria-hidden="true"
        wire:ignore.self
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bodegaModalLabel">
                        {{ $bodega_id ? 'Editar Bodega' : 'Crear Bodega' }}
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
                            <label for="nombre_bodega">Nombre de la Bodega</label>
                            <input
                                type="text"
                                class="form-control"
                                wire:model='nombre_bodega'
                                id="nombre_bodega"
                                value="{{ old('nombre_bodega') }}"
                            >
                            @error('nombre_bodega') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <label for="sucursales">Sucursal</label>
                            <select class="form-control" wire:model="id_sucursal" id="sucursales">
                                <option value="">Selecciona una sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_sucursal }}">{{ $sucursal->nombre_sucursal }}</option>
                                @endforeach
                            </select>
                            @error('id_sucursal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="empresas">Empresa</label>
                            <select class="form-control" wire:model="id_empresa" id="empresas">
                                <option value="">Selecciona una empresa</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_empresa }}</option>
                                @endforeach
                            </select>
                            @error('id_empresa') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer mt-3">
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
                        wire:click='guardarBodega'
                    >
                        {{ $bodega_id ? 'Actualizar Bodega' : 'Crear Bodega' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar bodegas">

        <table class="table">
            <thead class="table-dark">
            <tr>
                <td>ID Bodega</td>
                <td>Nombre Bodega</td>
                <td>Nombre Sucursal</td>
                <td>Nombre Empresa</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @forelse ($bodegas as $bodega)
                <tr>
                    <td>{{ $bodega->id_bodega }}</td>
                    <td>{{ $bodega->nombre_bodega }}</td>
                    <td>{{ $bodega->sucursal->nombre_sucursal ?? 'Sin sucursal' }}</td>
                    <td>{{ $bodega->empresa->nombre_empresa ?? 'Sin empresa' }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarBodega({{ $bodega->id_bodega }})" data-toggle="modal" data-target="#bodegaModal">Editar</a>
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
            {{ $bodegas->links() }}
        </div>
    </div>
</div>
