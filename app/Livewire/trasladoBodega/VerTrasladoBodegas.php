<?php

namespace App\Livewire\trasladoBodega;

use App\Models\Traslado;
use App\Models\Bodega;
use Livewire\Component;
use Livewire\WithPagination;

class VerTrasladoBodegas extends Component
{
    use WithPagination;

    public $search = '';

    public $traslado_id;
    public $documento_traslado;
    public $fecha_traslado;
    public $descripcion_traslado;
    public $id_bodega_origen;
    public $id_bodega_destino;

    public $bodegas = [];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'documento_traslado' => 'required|string',
        'fecha_traslado' => 'required|date',
        'descripcion_traslado' => 'nullable|string',
        'id_bodega_origen' => 'required|integer',
        'id_bodega_destino' => 'required|integer',
    ];

    public function mount()
    {
        $this->bodegas = Bodega::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $traslado = Traslado::with('detalles')->findOrFail($id);
        $this->traslado_id = $traslado->id_traslado;
        $this->documento_traslado = $traslado->documento_traslado;
        $this->fecha_traslado = $traslado->fecha_traslado;
        $this->descripcion_traslado = $traslado->descripcion_traslado;
        $this->id_bodega_origen = $traslado->id_bodega_origen;
        $this->id_bodega_destino = $traslado->id_bodega_destino;
    }

    public function updateTraslado()
    {
        $this->validate();

        try {
            $traslado = Traslado::findOrFail($this->traslado_id);
            $traslado->update([
                'documento_traslado' => $this->documento_traslado,
                'descripcion_traslado' => $this->descripcion_traslado,
                'id_bodega_origen' => $this->id_bodega_origen,
                'id_bodega_destino' => $this->id_bodega_destino,
            ]);

            session()->flash('success', 'Traslado actualizado correctamente.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error al actualizar el traslado.');
        }
    }

    public function render()
    {
        $traslados = Traslado::with('detalles')
            ->where('documento_traslado', 'LIKE', "%$this->search%")
            ->orWhere('fecha_traslado', 'LIKE', "%$this->search%")
            ->orWhere('descripcion_traslado', 'LIKE', "%$this->search%")
            ->orWhere('id_bodega_origen', 'LIKE', "%$this->search%")
            ->orWhere('id_bodega_destino', 'LIKE', "%$this->search%")
            ->paginate(10);

        return view('livewire.trasladoBodega.verTraslado', [
            'traslados' => $traslados,
        ]);
    }
}
