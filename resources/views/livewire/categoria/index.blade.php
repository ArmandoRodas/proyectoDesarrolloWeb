<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Categoria
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
                        {{ $id_categoria ? 'Editar Categoria' : 'Crear Categoria' }}
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
                        <label for="nombre_categoria">Nombre</label>
                        <input 
                            type="text" 
                            class="form-control"
                            wire:model='nombre_categoria'
                            id="nombre_categoria"
                            value="{{ old('nombre_categoria') }}"
                        >
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
                        type="button" 
                        class="btn btn-success" 
                        wire:click='guardarCategoria'
                    >
                        {{ $id_categoria ? 'Actualizar Categoria' : 'Crear Categoria' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla fuera del modal -->
    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar clientes">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Nombre</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre_categoria }}</td>
                        <td>{{ optional($categoria->estado)->nombre_estado ?? 'Sin estado' }}</td> {{-- Usar optional para evitar errores --}}
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarCategoria({{ $categoria->id_categoria }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
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
            {{ $categorias->links() }}
        </div>
    </div>
</div>
