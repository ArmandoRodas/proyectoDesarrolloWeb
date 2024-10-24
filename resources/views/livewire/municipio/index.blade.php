<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
        Crear Municipio
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

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ $municipio_id ? 'Editar Municipio' : 'Crear Municipio' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click='resetInput'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="nombre_municipio">Nombre del Municipio</label>
                        <input type="text" class="form-control" wire:model='nombre_municipio' id="nombre_municipio"
                            value="{{ old('nombre_municipio') }}">
                    </div>
                    <div>
                        <label for="pais_id">País</label>
                        <select class="form-control" wire:model.live='pais_id' id="pais_id">
                            <option value="">Selecciona un País</option>
                            @foreach($paises as $pais)
                                <option value="{{ $pais->id_pais }}">{{ $pais->nombre_pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="departamento_id">Departamento</label>
                        <select class="form-control" wire:model='departamento_id' id="departamento_id">
                            <option value="">Selecciona un Departamento</option>
                            @foreach($departamentos as $departamento)
                                @if ($departamento->id_pais == $pais_id) 
                                    <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre_departamento }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetInput'>
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" wire:click='guardar'>
                            {{ $municipio_id ? 'Actualizar Municipio' : 'Crear Municipio' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar Municipio">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Municipio</th>
                    <th>Departamento</th>
                    <th>País</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($municipios as $m) 
                    <tr>
                        <td>{{ $m->nombre_municipio }}</td> 
                        <td>{{ $m->departamento->nombre_departamento }}</td> 
                        <td>{{ $m->departamento->pais->nombre_pais }}</td> 
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click.prevent="editar({{ $m->id_municipio }})" data-toggle="modal"
                                data-target="#staticBackdrop">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Sin resultados</td> 
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
