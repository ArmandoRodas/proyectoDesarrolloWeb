<div>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
    Crear País
</button>

<!-- Mensajes de éxito o error -->
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

<!-- Modal para crear/editar país -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    {{ $pais_id ? 'Editar País' : 'Crear País' }} <!-- Cambiado a países -->
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click='resetInput'>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para país -->
                <div>
                    <label for="nombre_pais">Nombre del País</label>
                    <input type="text" class="form-control" wire:model='nombre_pais' id="nombre_pais"
                        value="{{ old('nombre_pais') }}">
                </div>
                <div>
                    <label for="codigo_pais">Código del País</label>
                    <input type="text" class="form-control" wire:model='codigo_pais' id="codigo_pais"
                        value="{{ old('codigo_pais') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetInput'>
                        Cerrar
                    </button>
                    <button type="submit" class="btn btn-success" data-dismiss="modal" wire:click='guardar'>
                        {{ $pais_id ? 'Actualizar País' : 'Crear País' }} <!-- Cambiado a países -->
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar Pais">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Nombre</td>
                    <td>Codigo</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($pais as $p)
                    <tr>
                        <td>{{ $p->nombre_pais }}</td>
                        <td>{{ $p->codigo_pais }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click.prevent="editar({{ $p->id_pais }})" data-toggle="modal"
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
    <div class="mt-3">
        {{ $pais->links() }}
    </div>
</div>
