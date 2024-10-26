<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Apertura de Caja
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
                        {{ $id_apertura_caja ? 'Editar Apertura' : 'Crear Apertura' }}
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
                        <label for="saldo_inicial_caja">Saldo inicial *</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            wire:model='saldo_inicial_caja'
                            id="saldo_inicial_caja"
                            step="0.01"
                            min="0"
                            value="{{ old('saldo_inicial_caja') }}"
                            {{ $id_apertura_caja ? 'disabled' : '' }}
                        >
                    </div>
                    <div>
                        <label for="id_caja">Caja *</label>
                        <select 
                            class="form-control"
                            wire:model="id_caja" 
                            id="id_caja"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($cajas as $caja)
                                <option 
                                    value="{{ $caja->id_caja }}"
                                >
                                    {{ $caja->nombre_caja}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="descripcion_apertura_caja">Descripcion apertura Caja</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            wire:model='descripcion_apertura_caja'
                            id="descripcion_apertura_caja"
                            value="{{ old('descripcion_apertura_caja') }}"
                        >
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
                            wire:click='guardarApertura'
                        >
                            {{ $id_apertura_caja ? 'Actualizar Apertura' : 'Crear Apertura' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar aperturas de cajas">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Nombre caja</td>
                    <td>Saldo inicial</td>
                    <td>Descripcion caja</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($aperturasCajas as $aperturaCaja)
                    <tr>
                        <td>{{ $aperturaCaja->caja->nombre_caja }}</td>
                        <td>{{ $aperturaCaja->saldo_inicial_caja }}</td>
                        <td>{{ $aperturaCaja->descripcion_apertura_caja }}</td>
                        <td>{{ $aperturaCaja->estado->nombre_estado }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarApertura({{ $aperturaCaja->id_apertura_caja }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
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
            {{ $aperturasCajas->links() }}
        </div>
    </div>
</div>