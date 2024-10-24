<div>
    
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
        Crear Departamento
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
                        {{ $departamento_id ? 'Editar Departamento' : 'Crear Departamento' }} 
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click='resetInput'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="nombre_departamento">Nombre del Departamento</label>
                        <input type="text" class="form-control" wire:model='nombre_departamento' id="nombre_departamento"
                            value="{{ old('nombre_departamento') }}">
                    </div>
                    <div>
                        <label for="pais_id">País</label>
                        <select class="form-control" wire:model='pais_id' id="pais_id">
                            <option value="">Selecciona un País</option>
                            @foreach($paises as $pais)
                                <option value="{{ $pais->id_pais }}">{{ $pais->nombre_pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetInput'>
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" wire:click='guardar'>
                            {{ $departamento_id ? 'Actualizar Departamento' : 'Crear Departamento' }} <!-- Cambiado a departamentos -->
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar Departamento o País">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Departamento</td>
                    <td>País</td>
                    <td>Acciones</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($departamentos as $d) 
                    <tr>
                        <td>{{ $d->nombre_departamento }}</td>
                        <td>{{ $d->pais->nombre_pais }}</td> 
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click.prevent="editar({{ $d->id_departamento }})" data-toggle="modal"
                                data-target="#staticBackdrop">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
