<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
        Crear Proveedor
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
                        {{ $proveedor_id ? 'Editar proveedor' : 'Crear proveedor' }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        wire:click='resetInput'>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="codigo_proveedor">Codigo</label>
                        <input type="text" class="form-control" wire:model='codigo_proveedor' id="codigo_proveedor"
                            value="{{ old('codigo_proveedor') }}">
                    </div>
                    <div>
                        <label for="nombre_proveedor">Nombre</label>
                        <input type="text" class="form-control" wire:model='nombre_proveedor' id="nombre_proveedor"
                            value="{{ old('nombre_proveedor') }}">
                    </div>
                    <div>
                        <label for="nit_proveedor">Nit</label>
                        <input type="text" class="form-control" wire:model='nit_proveedor' id="nit_proveedor"
                            value="{{ old('nit_proveedor') }}">
                    </div>
                    <div>
                        <label for="direccion_proveedor">Dirección</label>
                        <input type="text" class="form-control" wire:model='direccion_proveedor' id="direccion_proveedor"
                            value="{{ old('direccion_proveedor') }}">
                    </div>
                    <div>
                        <label for="telefono_proveedor">Telefono</label>
                        <input type="text" class="form-control" wire:model='telefono_proveedor' id="telefono_proveedor"
                            value="{{ old('telefono_proveedor') }}">
                    </div>
                    <div>
                        <label for="correo_proveedor">Correo</label>
                        <input type="text" class="form-control" wire:model='correo_proveedor' id="correo_proveedor"
                            value="{{ old('correo_proveedor') }}">
                    </div>
                    <div>
                        <label for="cui_proveedor">CUI</label>
                        <input type="text" class="form-control" wire:model='cui_proveedor' id="cui_proveedor"
                            value="{{ old('direccion_proveedor') }}">
                    </div>
                    <div>
                        <label for="estado_proveedor">Estado</label>
                        <select class="form-control" wire:model='estado_proveedor' id="estado_proveedor">
                            <option value="1" {{ $estado_proveedor == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $estado_proveedor == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetInput'>
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" wire:click='guardar'>
                            {{ $proveedor_id ? 'Actualizar proveedor' : 'Crear proveedor' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar proveedors">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Codigo</td>
                    <td>Nombre</td>
                    <td>Nit</td>
                    <td>Direccion</td>
                    <td>Telefono</td>
                    <td>Correo</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($proveedor as $pr)
                    <tr>
                        <td>{{ $pr->codigo_proveedor }}</td>
                        <td>{{ $pr->nombre_proveedor }}</td>
                        <td>{{ $pr->nit_proveedor }}</td>
                        <td>{{ $pr->direccion_proveedor }}</td>
                        <td>{{ $pr->telefono_proveedor }}</td>
                        <td>{{ $pr->correo_proveedor }}</td>
                        <td>
                            @if ($pr->estado_proveedor == 1)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"
                                wire:click.prevent="editar({{ $pr->id }})" data-toggle="modal"
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
        {{ $proveedor->links() }}
    </div>
</div>
