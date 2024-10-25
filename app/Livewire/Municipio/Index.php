<?php

namespace App\Livewire\Municipio;

use App\Models\Municipio;
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

    public $municipio_id;
    public $nombre_municipio;
    public $departamento_id;
    public $pais_id;

    protected $rules = [
        'nombre_municipio' => 'required',
        'departamento_id' => 'required|exists:tbl_departamento,id_departamento',
        'pais_id' => 'required|exists:tbl_pais,id_pais', 
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset(['nombre_municipio', 'municipio_id','departamento_id', 'pais_id']);
    }

    public function guardar()
    {
        DB::beginTransaction();
        try {
            $this->validate();

            if ($this->municipio_id) {
                $municipio = Municipio::find($this->municipio_id);
                $municipio->update([
                    'nombre_municipio' => $this->nombre_municipio,
                    'id_departamento' => $this->departamento_id
                ]);
                session()->flash('success', 'Municipio actualizado correctamente.');
            } else {
                Municipio::create([
                    'nombre_municipio' => $this->nombre_municipio,
                    'id_departamento' => $this->departamento_id
                ]);
                session()->flash('success', 'Municipio creado correctamente.');
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
        $municipio = Municipio::with('departamento.pais')->findOrFail($id); 
        $this->municipio_id = $municipio->id_municipio;
        $this->nombre_municipio = $municipio->nombre_municipio;
        $this->departamento_id = $municipio->departamento->id_departamento;
        $this->pais_id = $municipio->departamento->pais->id_pais;
    }

    public function render()
    {
        $municipios = Municipio::with('departamento.pais') 
            ->where('nombre_municipio', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $departamentos = Departamento::all(); 
        $paises = Pais::all(); 

        return view('livewire.municipio.Index', [
            'paises' => $paises,
            'departamentos' => $departamentos,
            'municipios' => $municipios,

        ]);
    }
}
