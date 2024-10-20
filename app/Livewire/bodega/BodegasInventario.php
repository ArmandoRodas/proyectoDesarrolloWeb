<?php
namespace App\Livewire\bodega;

use App\Models\Bodega;
use App\Models\BodegaProducto;
use Livewire\Component;

class BodegasInventario extends Component
{
    public $bodegaId;
    public $nombreBodega;
    public $productosEnBodega;

    public function mount($bodegaId)
    {
        $this->bodegaId = $bodegaId;

        $this->nombreBodega = Bodega::find($this->bodegaId)->nombre_bodega;

        $this->productosEnBodega = BodegaProducto::where('id_bodega', $this->bodegaId)->with('producto')->get();
    }

    public function render()
    {
        return view('livewire.bodega.index', [
            'productosEnBodega' => $this->productosEnBodega,
        ]);
    }

}
