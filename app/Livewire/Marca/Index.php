<?php

namespace App\Livewire\Marca;

use App\Models\Marca;
use App\Models\Estado;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $id_marca, $nombre_marca, $id_estado;
    public $estado_filter = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nombre_marca' => 'required|max:50',
        'id_estado' => 'required|exists:tbl_estado,id_estado',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedEstadoFilter()
    {
        $this->resetPage();
    }

    // Cargar datos de la marca para edición
    public function editarMarca($id)
    {
        $marca = Marca::findOrFail($id);

        $this->id_marca = $marca->id_marca;
        $this->nombre_marca = $marca->nombre_marca;
        $this->id_estado = $marca->id_estado;
    }

    public function guardarMarca()
    {
        $this->validate();

        Marca::updateOrCreate(
            ['id_marca' => $this->id_marca],
            [
                'nombre_marca' => $this->nombre_marca,
                'id_estado' => $this->id_estado,
            ]
        );

        session()->flash('success', $this->id_marca ? 'Marca actualizada correctamente.' : 'Marca creada correctamente.');

        $this->resetInput();
    }

    public function eliminarMarca($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();

        session()->flash('success', 'Marca eliminada correctamente.');
    }

    public function resetInput()
    {
        $this->reset([
            'id_marca',
            'nombre_marca',
            'id_estado',
        ]);
    }

    public function render()
    {
        $marcas = Marca::query()
            ->when($this->estado_filter, function ($query) {
                $query->where('id_estado', $this->estado_filter);
            })
            ->when($this->search, function ($query) {
                $query->where('nombre_marca', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $estados = Estado::all();

        return view('livewire.marca.index', [
            'marcas' => $marcas,
            'estados' => $estados
        ]);
    }
}
