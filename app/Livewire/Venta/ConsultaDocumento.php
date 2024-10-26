<?php

namespace App\Livewire\Venta;

use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ConsultaDocumento extends Component
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
        $documentosQuery = Venta::orderBy('created_at', 'desc');

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
            })->orWhere('documento_venta', 'like', '%' . $this->query . '%');
        }
        
        $documentos = $documentosQuery->paginate(10);

        return view('livewire.venta.consulta-documento', [
            'documentos' => $documentos
        ]);
    }
}
