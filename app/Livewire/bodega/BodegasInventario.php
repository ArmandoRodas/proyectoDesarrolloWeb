<?php
namespace App\Livewire\bodega;

use App\Models\Bodega;
use App\Models\BodegaProducto;
use Livewire\Component;
use Livewire\WithPagination;

class BodegasInventario extends Component
{
    public $bodegaId;
    public $nombreBodega;
    public $bodegas;
    public $search = '';

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // Obtener todas las bodegas para llenar el selector
        $this->bodegas = Bodega::all();
        $this->bodegaId = null;
        $this->nombreBodega = '';
    }

    public function cambiarBodega($bodegaId)
    {
        $this->bodegaId = $bodegaId;

        if ($this->bodegaId) {
            $this->nombreBodega = Bodega::find($this->bodegaId)->nombre_bodega;
        } else {
            $this->nombreBodega = '';
        }

        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $productosEnBodega = [];
        if ($this->bodegaId) {
            $productosEnBodega = BodegaProducto::where('id_bodega', $this->bodegaId)
                ->whereHas('producto', function ($query) {
                    $query->where('nombre_producto', 'like', '%' . $this->search . '%');
                })
                ->with('producto')
                ->paginate(10);
        }

        return view('livewire.bodega.index', [
            'productosEnBodega' => $productosEnBodega,
        ]);
    }
}
