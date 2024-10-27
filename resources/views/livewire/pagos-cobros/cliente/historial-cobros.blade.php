<div>
    <form wire:submit.prevent="consultarDocumento" class="row d-flex align-items-center justify-content-center mt-5">
        <div class="col">
            <label for="fechaInicio">Desde</label>
            <input wire:model="fechaInicio" id="fechaInicio" type="date" class="form-control">
        </div>
        <div class="col">
            <label for="fechaFin">Hasta</label>
            <input wire:model="fechaFin" id="fechaFin" type="date" class="form-control">
        </div>
        <div class="col mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="col">
            <label for="query">Buscar</label>
            <input type="text" class="form-control" wire:model.live="query" id="query" placeholder="Buscar Documentos">
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table shadow mt-3">
        <thead class="table-dark">
            <tr>
                <td>Fecha pago</td>
                <td>Cliente</td>
                <td>Documento</td>
                <td>Monto abonado</td>
                <td>Ref</td>
                <td>Estado</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($historialPagos as $documento)
                <tr>
                    <td>{{ date('d-m-Y H:i:s', strtotime($documento->created_at)) }}</td>
                    <td>
                        {{ $documento->cxc->cliente->codigo_persona }} : {{ $documento->cxc->cliente->nombre_persona }}
                    </td>
                    <td>
                        <a 
                            href="{{ route('consultaDocumentoDetalle', $documento->cxc->venta) }}"
                            class="btn btn-sm btn-success"
                        >
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        {{ $documento->cxc->venta->tipoDocumento->nombre_tipoDocumento }}: {{ $documento->cxc->venta->documento_venta }}
                    </td>
                    <td>Q.{{ $documento->monto_pagado_historial_cxc }}</td>
                    <td>{{ $documento->referencia_pago_historial_cxc }}</td>
                    <td>{{ $documento->cxc->estado->nombre_estado }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger">
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No se encontro ningun resultado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($historialPagos->hasPages())   
        {{ $historialPagos->links() }}
    @endif
</div>
