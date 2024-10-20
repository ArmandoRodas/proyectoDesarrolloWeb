<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Subcategoría
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
                        {{ $id_subcategoria ? 'Editar Subcategoría' : 'Crear Subcategoría' }}
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
                        <label for="nombre_subcategoria">Nombre</label>
                        <input 
                            type="text" 
                            class="form-control"
                            wire:model='nombre_subcategoria'
                            id="nombre_subcategoria"
                            value="{{ old('nombre_subcategoria') }}"
                        >
                    </div>
                    <div>
                        <form wire:submit.prevent="guardarSubcategoria">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <select wire:model="id_categoria" class="form-control" required>
                                    <option value="">Seleccionar categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select wire:model="id_estado" class="form-control" required>
                                    <option value="">Seleccionar estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="form-group">
                                <label for="nombre_subcategoria">Nombre de la Subcategoría</label>
                                <input type="text" wire:model="nombre_subcategoria" class="form-control" required>
                            </div>
                        </form>
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
                        wire:click='guardarSubcategoria'
                    >
                        {{ $id_subcategoria ? 'Actualizar Subcategoría' : 'Crear Subcategoría' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla fuera del modal -->
    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar subcategorías">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Subcategoria</td>
                    <td>Categoría</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($subcategorias as $subcategoria)
                    <tr>
                        <td>{{ $subcategoria->nombre_subcategoria }}</td>
                        <td>{{ optional($subcategoria->categoria)->nombre_categoria ?? 'Sin categoría' }}</td> 
                        <td>{{ optional($subcategoria->estado)->nombre_estado ?? 'Sin estado' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarSubcategoria({{ $subcategoria->id_subcategoria }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
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
            {{ $subcategorias->links() }}
        </div>
    </div>
</div>
