<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Crear Caja
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
                        {{ $id_caja ? 'Editar Caja' : 'Crear Caja' }}
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
                        <label for="nombre_caja">Nombre caja *</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            wire:model='nombre_caja'
                            id="nombre_caja"
                            value="{{ old('nombre_caja') }}"
                        >
                    </div>
                    <div>
                        <label for="descripcion_caja">Descripcion Caja</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            wire:model='descripcion_caja'
                            id="descripcion_caja"
                            value="{{ old('descripcion_caja') }}"
                        >
                    </div>
                    <div>
                        <label for="id_sucursal">Sucursal *</label>
                        <select 
                            class="form-control"
                            wire:model="id_sucursal" 
                            id="id_sucursal"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($sucursales as $sucursal)
                                <option 
                                    value="{{ $sucursal->id_sucursal }}"
                                >
                                    {{ $sucursal->nombre_sucursal }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_empresa">Empresa *</label>
                        <select 
                            class="form-control"
                            wire:model="id_empresa" 
                            id="id_empresa"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($empresas as $empresa)
                                <option 
                                    value="{{ $empresa->id_empresa }}"
                                >
                                    {{ $empresa->nombre_empresa }}
                                </option>
                            @endforeach
                        </select>
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
                            wire:click='guardarCaja'
                        >
                            {{ $id_caja ? 'Actualizar Caja' : 'Crear Caja' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar cajas">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Nombre caja</td>
                    <td>Descripcion caja</td>
                    <td>Sucursal</td>
                    <td>Empresa</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($cajas as $caja)
                    <tr>
                        <td>{{ $caja->nombre_caja }}</td>
                        <td>{{ $caja->descripcion_caja }}</td>
                        <td>{{ $caja->sucursal->nombre_sucursal ?? null }}</td>
                        <td>{{ $caja->empresa->nombre_empresa ?? null }}</td>
                        <td>{{ $caja->estado->nombre_estado }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarCaja({{ $caja->id_caja }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $cajas->links() }}
        </div>
    </div>
</div>