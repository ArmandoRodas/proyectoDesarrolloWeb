<?php

namespace App\Livewire\Categoria;

use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public $estados = [];

    use WithPagination;

    public $search = '';

    public $id_categoria;
    public $nombre_categoria;
    public $id_estado;
    

    protected $paginationTheme = 'bootstrap';
     
    protected $rules = [
        'nombre_categoria' => 'required|string|max:255',
        'id_estado' => 'required|integer|exists:tbl_estado,id_estado',  //asegura que el estado exista
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarCategoria()
    {
        DB::beginTransaction();

        try {
            $this->validate();
            //dd($this->id_estado);  //depuracion
            if (empty($this->id_estado)) {
                session()->flash('error', 'Debes seleccionar un estado válido.');
                return;
            }


            if ($this->id_categoria) {
                // Editar categoría
                $categoria = Categoria::find($this->id_categoria);

                $categoria->update([
                    'nombre_categoria' => $this->nombre_categoria,
                    'id_estado'=> $this->id_estado,
                ]);

                session()->flash('success', 'Categoría actualizada correctamente.');
            } else {
                // Crear categoría
                Categoria::create([
                    'nombre_categoria' => $this->nombre_categoria,
                    'id_estado' => $this->id_estado,
                ]);


                session()->flash('success', 'Categoría creada correctamente.');
            }

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->id_categoria = $categoria->id_categoria;
        $this->nombre_categoria = $categoria->nombre_categoria;
        $this->id_estado = $categoria->id_estado;
    }

    public function resetInput()
    {
        $this->reset([
            'id_categoria',
            'nombre_categoria',
            'id_estado'
        ]);
    }

    public function render()
    {
        $categorias = Categoria::where('nombre_categoria', 'like', '%' . $this->search . '%')
        ->orWhere('id_estado', 'like', '%' . $this->search . '%')
        ->paginate(10);

        return view('livewire.categoria.index', [
            'categorias' => $categorias,
            'estados' => $this->estados
        ]);
    }

    public function mount()
    {
        $this->estados = Estado::all();
    }
}
