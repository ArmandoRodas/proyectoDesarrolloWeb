<?php

namespace App\Livewire\Pais;

use App\Models\Pais;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $pais_id;
    public $codigo_pais;
    public $nombre_pais;

    protected $rules = [
        'codigo_pais' => 'required',
        'nombre_pais' => 'required'
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset([
            'codigo_pais',
            'nombre_pais'
        ]);
    }

    public function guardar()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            if ($this->pais_id) {
                // Actualizar país existente
                $pais = Pais::find($this->pais_id);
                $pais->update([
                    'codigo_pais' => $this->codigo_pais,
                    'nombre_pais' => $this->nombre_pais
                ]);
                session()->flash('success', 'País actualizado correctamente.');
            } else {
                // Crear nuevo país
                Pais::create([
                    'codigo_pais' => $this->codigo_pais,
                    'nombre_pais' => $this->nombre_pais
                ]);
                session()->flash('success', 'País creado correctamente.');
            }
            DB::commit();
            $this->resetInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editar($id)
    {
        $pais = Pais::findOrFail($id); 
        $this->pais_id = $pais->id_pais; 
        $this->nombre_pais = $pais->nombre_pais; 
        $this->codigo_pais = $pais->codigo_pais; 
    }
    

    public function render()
    {
        $pais = Pais::where(function ($query) {
            $query->where('codigo_pais', 'like', '%' . $this->search . '%')
                ->orWhere('nombre_pais', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.pais.index', [
            'pais' => $pais
        ]);
    }
}
