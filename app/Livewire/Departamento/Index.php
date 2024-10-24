<?php

namespace App\Livewire\Departamento;

use App\Models\Departamento;
use App\Models\Pais;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $departamento_id;
    public $nombre_departamento;
    public $pais_id;

    protected $rules = [
        'nombre_departamento' => 'required',
        'pais_id' => 'required|exists:tbl_pais,id_pais',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset(['nombre_departamento', 'pais_id']);
    }
    public function guardar()
    {
        DB::beginTransaction();
        try {
            $this->validate();
    
            if ($this->departamento_id) {
                // Actualizar departamento existente
                $departamento = Departamento::find($this->departamento_id);
                $departamento->update([
                    'nombre_departamento' => $this->nombre_departamento,
                    'id_pais' => $this->pais_id
                ]);
                session()->flash('success', 'Departamento actualizado correctamente.');
            } else {
                // Crear nuevo departamento
                Departamento::create([
                    'nombre_departamento' => $this->nombre_departamento,
                    'id_pais' => $this->pais_id
                ]);
                session()->flash('success', 'Departamento creado correctamente.');
            }
    
            DB::commit();
            $this->resetInput();
            //$this->emit('closeModal'); // Para cerrar el modal después de guardar
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }
    

    public function editar($id)
    {
        $departamento = Departamento::findOrFail($id);
        $this->departamento_id = $departamento->id_departamento;
        $this->nombre_departamento = $departamento->nombre_departamento;
        $this->pais_id = $departamento->id_pais; // Asegúrate de que se carga el país relacionado
    }

    public function render()
    {
        $departamentos = Departamento::with('pais') // Cargar la relación 'pais'
            ->where('nombre_departamento', 'like', '%' . $this->search . '%')
            ->paginate(10);

        // Obtener la lista de países para el formulario
        $paises = Pais::all(); 

        return view('livewire.departamento.index', [
            'departamentos' => $departamentos,
            'paises' => $paises, // Pasar los países a la vista
        ]);
    }
}