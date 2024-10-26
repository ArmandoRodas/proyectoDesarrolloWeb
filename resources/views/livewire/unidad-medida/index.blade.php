<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Unidad de Medida
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
                        {{ $id_unidad_medida ? 'Editar Unidad de Medida' : 'Crear Unidad de Medida' }}
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
                        <label for="codigo_unidad_medida">Código de la Unidad de Medida *</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='codigo_unidad_medida'
                            id="codigo_unidad_medida"
                            value="{{ old('codigo_unidad_medida') }}"
                        >
                    </div>
                    <div>
                        <label for="nombre_unidad_medida">Nombre de la Unidad de Medida *</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model='nombre_unidad_medida'
                            id="nombre_unidad_medida"
                            value="{{ old('nombre_unidad_medida') }}"
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
                            wire:click='guardarUnidadMedida'
                        >
                            {{ $id_unidad_medida ? 'Actualizar Unidad de Medida' : 'Crear Unidad de Medida' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-md-6">
            <label for="search">Buscar Unidades de Medida</label>
            <input
                type="text"
                class="form-control form-control-sm"
                id="search"
                wire:model.live="search"
                placeholder="Buscar unidades de medida"
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
                <td>Código</td>
                <td>Nombre</td>
                <td>Estado</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($unidadesMedida as $unidadMedida)
                <tr>
                    <td>{{ $unidadMedida->codigo_unidad_medida }}</td>
                    <td>{{ $unidadMedida->nombre_unidad_medida }}</td>
                    <td>{{ $unidadMedida->estado->nombre_estado }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarUnidadMedida({{ $unidadMedida->id_unidad_medida }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Sin resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $unidadesMedida->links() }}
    </div>
</div>

