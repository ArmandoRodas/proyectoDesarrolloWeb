<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Cliente
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
                        {{ $id_tipo_persona ? 'Editar Cliente' : 'Crear Cliente' }}
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
                    {{-- <form wire:submit="guardarCliente"> --}}
                        <div>
                            <label for="nombre_persona">Nombre del cliente *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='nombre_persona'
                                id="nombre_persona"
                                value="{{ old('nombre_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="direccion_persona">Dirección del cliente *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='direccion_persona'
                                id="direccion_persona"
                                value="{{ old('direccion_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="telefono_persona">Telefono cliente *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='telefono_persona'
                                id="telefono_persona"
                                value="{{ old('telefono_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="correo_persona">Correo cliente</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='correo_persona'
                                id="correo_persona"
                                value="{{ old('correo_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="nit_persona">Nit del cliente *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='nit_persona'
                                id="nit_persona"
                                value="{{ old('nit_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="cui_persona">CUI del cliente *</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                wire:model='cui_persona'
                                id="cui_persona"
                                value="{{ old('cui_persona') }}"
                            >
                        </div>
                        <div>
                            <label for="id_tipo_persona">Tipo Persona</label>
                            <select 
                                class="form-control"
                                wire:model="id_tipo_persona" 
                                id="id_tipo_persona"
                            >
                                @foreach ($tiposDePersonas as $tipoPersona)
                                    <option value="{{ $tipoPersona->id_tipo_persona }}">{{ $tipoPersona->nombre_tipo_persona }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="id_estado">Estado</label>
                            <select 
                                class="form-control"
                                wire:model="id_estado" 
                                id="id_estado"
                            >
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
                                wire:click='guardarCliente'
                            >
                                {{ $id_tipo_persona ? 'Actualizar Cliente' : 'Crear Cliente' }}
                            </button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar clientes">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Codigo Cliente</td>
                    <td>Nombre Cliente</td>
                    <td>Direccion Cliente</td>
                    <td>Telefono Cliente</td>
                    <td>Correo Cliente</td>
                    <td>NIT Cliente</td>
                    <td>CUI Cliente</td>
                    <td>Tipo</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->codigo_persona }}</td>
                        <td>{{ $cliente->nombre_persona }}</td>
                        <td>{{ $cliente->direccion_persona }}</td>
                        <td>{{ $cliente->telefono_persona }}</td>
                        <td>{{ $cliente->correo_persona }}</td>
                        <td>{{ $cliente->nit_persona }}</td>
                        <td>{{ $cliente->cui_persona }}</td>
                        <td>{{ $cliente->tipoPersona->nombre_tipo_persona }}</td>
                        <td>{{ $cliente->estado->nombre_estado }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarCliente({{ $cliente->id_persona }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
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
            {{ $clientes->links() }}
        </div>
    </div>
</div>