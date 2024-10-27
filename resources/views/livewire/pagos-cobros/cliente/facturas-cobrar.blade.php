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
                <td>Fecha del documento</td>
                <td>Cliente</td>
                <td>Documento</td>
                <td>Tipo Venta</td>
                <td>Metodo Pago</td>
                <td>Monto</td>
                <td>Dias credito</td>
                <td>Fecha vencimiento</td>
                <td>Saldo pendiente fact.</td>
                <td>Estado</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($documentos as $documento)
                <tr>
                    <td>{{ date('d-m-Y H:i:s', strtotime($documento->created_at)) }}</td>
                    <td>
                        {{ $documento->cliente->codigo_persona }} : {{ $documento->cliente->nombre_persona }}
                    </td>
                    <td>
                        <a 
                            href="{{ route('consultaDocumentoDetalle', $documento->venta) }}"
                            class="btn btn-sm btn-success"
                        >
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        {{ $documento->venta->tipoDocumento->nombre_tipoDocumento }}: {{ $documento->venta->documento_venta }}
                    </td>
                    <td>{{ $documento->venta->tipoVenta->nombre_tipoVenta }}</td>
                    <td>{{ $documento->venta->metodoPago->nombre_metodo_pago }}</td>
                    <td>Q.{{ $documento->venta->total_venta }}</td>
                    <td>{{ $documento->dias_credito }}</td>
                    <td>{{ date('d-m-Y', strtotime($documento->fecha_vencimiento_cxc)) }}</td>
                    <td>Q.{{ $documento->saldo_pendiente_cxc }}</td>
                    <td>{{ $documento->estado->nombre_estado }}</td>
                    <td>
                        <a 
                            href="{{ route('pdf.venta', $documento->venta) }}"
                            class="btn btn-sm btn-danger"
                            target="_blank"
                        >
                            <i class="far fa-file-pdf"></i>
                        </a>
                        @if ($documento->estado->id_estado != 5)    
                            <a 
                                href="{{ route('pagoFactura', $documento) }}"
                                class="btn btn-sm btn-success"
                            >
                                <i class="fas fa-money-bill-alt"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No se encontro ningun resultado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($documentos->hasPages())   
        {{ $documentos->links() }}
    @endif
</div>
