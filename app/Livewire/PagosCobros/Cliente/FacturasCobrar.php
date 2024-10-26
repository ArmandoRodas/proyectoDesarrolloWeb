<?php

namespace App\Livewire\PagosCobros\Cliente;

use App\Models\CuentaPorCobrar;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class FacturasCobrar extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $fechaInicio;
    public $fechaFin;
    public $query = '';

    public function mount()
    {
        // Establecer las fechas por defecto
        $this->fechaInicio = Carbon::now()->format('Y-m-d');
        $this->fechaFin = Carbon::now()->format('Y-m-d');
    }
    
    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function consultarDocumento()
    {
        $this->dispatch('filtrar-documentos', [
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }

    public function render()
    {
        $documentosQuery = CuentaPorCobrar::orderBy('created_at', 'desc');

        if ($this->fechaInicio && $this->fechaFin) {
            $documentosQuery->whereBetween('created_at', [
                Carbon::parse($this->fechaInicio)->startOfDay(),
                Carbon::parse($this->fechaFin)->endOfDay(),
            ]);
        }

        if ($this->query) {
            $documentosQuery->whereHas('cliente', function ($query) {
                $query->where('nombre_persona', 'like', '%' . $this->query . '%')
                ->orWhere('codigo_persona', 'like', '%' . $this->query . '%');
            })->orWhereHas('venta', function ($query) {
                $query->where('documento_venta', 'like', '%' . $this->query . '%');
            });
        }
        
        $documentos = $documentosQuery->paginate(10);

        return view('livewire.pagos-cobros.cliente.facturas-cobrar', [
            'documentos' => $documentos
        ]);
    }
}
