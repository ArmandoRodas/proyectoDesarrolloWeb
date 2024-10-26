<?php

namespace App\Livewire\PagosCobros\Cliente;

use App\Models\HistorialCXC;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class HistorialCobros extends Component
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
    
    public function consultarDocumento()
    {
        $this->dispatch('filtrar-documentos', [
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        // $historialPagos = HistorialCXC::paginate(10);
        $documentosQuery = HistorialCXC::orderBy('created_at', 'desc');

        if ($this->fechaInicio && $this->fechaFin) {
            $documentosQuery->whereBetween('created_at', [
                Carbon::parse($this->fechaInicio)->startOfDay(),
                Carbon::parse($this->fechaFin)->endOfDay(),
            ]);
        }

        if ($this->query) {
            $documentosQuery->where('referencia_pago_historial_cxc', 'like', '%' . $this->query . '%');
        }
        
        $historialPagos = $documentosQuery->paginate(10);

        return view('livewire.pagos-cobros.cliente.historial-cobros', [
            'historialPagos' => $historialPagos
        ]);
    }
}
