<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Marca
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
                        {{ $id_marca ? 'Editar Marca' : 'Crear Marca' }}
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
                        <label for="nombre_marca">Nombre de la Marca *</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='nombre_marca'
                            id="nombre_marca"
                            value="{{ old('nombre_marca') }}"
                        >
                    </div>
                    <div>
                        <label for="id_estado">Estado *</label>
                        <select
                            class="form-control"
                            wire:model="id_estado"
                            id="id_estado"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($estados as $estado)
                                <option
                                    value="{{ $estado->id_estado }}"
                                >
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
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
                            wire:click='guardarMarca'
                        >
                            {{ $id_marca ? 'Actualizar Marca' : 'Crear Marca' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-md-6">
            <label for="search">Buscar Marcas</label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="search"
                wire:model.live="search"
                placeholder="Buscar marcas"
            >
        </div>
        <div class="col-md-3">
            <label for="estado_filter">Estado</label>
            <select
                class="form-control form-control-sm"
                id="estado_filter"
                wire:model.live="estado_filter"
            >
                <option value="">-- Todos --</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <td>Nombre</td>
                <td>Estado</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($marcas as $marca)
                <tr>
                    <td>{{ $marca->nombre_marca }}</td>
                    <td>{{ $marca->estado->nombre_estado }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarMarca({{ $marca->id_marca }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
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
        {{ $marcas->links() }}
    </div>
</div>
