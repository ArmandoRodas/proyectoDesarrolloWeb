<?php

namespace App\Livewire\bodega;

use App\Models\Bodega;
use App\Models\Empresa;
use App\Models\Sucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BodegaIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $bodega_id;
    public $nombre_bodega;
    public $id_sucursal;
    public $id_empresa;

    public $sucursales = [];
    public $empresas = [];


    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nombre_bodega' => 'required|string',
        'id_sucursal' => 'required|integer',
        'id_empresa' => 'required|integer',
    ];

    public function mount()
    {
        $this->sucursales = Sucursal::all();
        $this->empresas = Empresa::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarBodega()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            if ($this->bodega_id) {
                // Editar bodega
                $bodega = Bodega::find($this->bodega_id);

                $bodega->update([
                    'nombre_bodega' => $this->nombre_bodega,
                    'id_sucursal' => $this->id_sucursal,
                    'id_empresa' => $this->id_empresa,
                ]);

                session()->flash('success', 'Bodega actualizada correctamente.');
            } else {
                // Crear bodega
                Bodega::create([
                    'nombre_bodega' => $this->nombre_bodega,
                    'id_sucursal' => $this->id_sucursal,
                    'id_empresa' => $this->id_empresa,
                ]);

                session()->flash('success', 'Bodega creada correctamente.');
            }

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarBodega($id)
    {
        $bodega = Bodega::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->bodega_id = $bodega->id_bodega;
        $this->nombre_bodega = $bodega->nombre_bodega;
        $this->id_sucursal = $bodega->id_sucursal;
        $this->id_empresa = $bodega->id_empresa;
    }

    public function resetInput()
    {
        $this->reset([
            'bodega_id',
            'nombre_bodega',
            'id_sucursal',
            'id_empresa'
        ]);
    }

    public function render()
    {
        $bodegas = Bodega::where('nombre_bodega', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.bodega.create', [
            'bodegas' => $bodegas,
        ]);
    }
}
