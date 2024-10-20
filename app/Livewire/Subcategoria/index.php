<?php

namespace App\Livewire\Subcategoria;

use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $categorias = [];
    public $estados = [];

    use WithPagination;

    public $search = '';
    public $id_subcategoria;
    public $nombre_subcategoria;
    public $id_categoria;
    public $id_estado;
    
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nombre_subcategoria' => 'required|string|max:255',
        'id_categoria' => 'required|integer|exists:tbl_categoria,id_categoria',
        'id_estado' => 'required|integer|exists:tbl_estado,id_estado',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarSubcategoria()
    {
        DB::beginTransaction();

        try {
            $this->validate();
            
            if (empty($this->id_estado) || empty($this->id_categoria)) {
                session()->flash('error', 'Debes seleccionar un estado y una categoría válidos.');
                return;
            }

            if ($this->id_subcategoria) {
                // Editar subcategoría
                $subcategoria = Subcategoria::find($this->id_subcategoria);

                $subcategoria->update([
                    'nombre_subcategoria' => $this->nombre_subcategoria,
                    'id_categoria' => $this->id_categoria,
                    'id_estado' => $this->id_estado,
                ]);

                session()->flash('success', 'Subcategoría actualizada correctamente.');
            } else {
                // Crear subcategoría
                Subcategoria::create([
                    'nombre_subcategoria' => $this->nombre_subcategoria,
                    'id_categoria' => $this->id_categoria,
                    'id_estado' => $this->id_estado,
                ]);

                session()->flash('success', 'Subcategoría creada correctamente.');
            }

            DB::commit();
            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarSubcategoria($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);

        $this->id_subcategoria = $subcategoria->id_subcategoria;
        $this->nombre_subcategoria = $subcategoria->nombre_subcategoria;
        $this->id_categoria = $subcategoria->id_categoria;
        $this->id_estado = $subcategoria->id_estado;
    }

    public function resetInput()
    {
        $this->reset([
            'id_subcategoria',
            'nombre_subcategoria',
            'id_categoria',
            'id_estado'
        ]);
    }

    public function render()
    {
            $this->categorias = Categoria::all(); // Cargar todas las categorías
            $this->estados = Estado::all(); // Cargar todos los estados
        
            $subcategorias = Subcategoria::where('nombre_subcategoria', 'like', '%' . $this->search . '%')
                ->orWhereHas('categoria', function($query) {
                    $query->where('nombre_categoria', 'like', '%' . $this->search . '%');
                })  // Buscamos dentro de la relación 'categoria'
                ->orWhereHas('estado', function($query) {
                    $query->where('nombre_estado', 'like', '%' . $this->search . '%');
                })  // Buscamos dentro de la relación 'estado'
                ->paginate(10);
        
            return view('livewire.subcategoria.index', [
                'subcategorias' => $subcategorias,
                'categorias' => $this->categorias, // Pasar las categorías a la vista
                'estados' => $this->estados // Pasar los estados a la vista
            ]);
    }

    public function updatedIdCategoria($value)
    {
    $categoria = Categoria::find($value);
    if ($categoria) {
        $this->id_estado = $categoria->id_estado; // Cargar automáticamente el estado
    }
    }

}
