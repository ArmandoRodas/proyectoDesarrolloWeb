<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use App\Models\Empresa;
use App\Models\Estado;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id_caja;
    public $nombre_caja;
    public $id_sucursal;
    public $descripcion_caja;
    public $id_estado;
    public $id_empresa;

    public $search = '';
    
    protected $rules = [
        'nombre_caja' => 'required',
        'id_sucursal' => 'nullable',
        'descripcion_caja' => 'nullable|max:75',
        'id_estado' => 'required',
        'id_empresa' => 'nullable'
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarCaja()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            Caja::updateOrCreate(
                ['id_caja' => $this->id_caja],
                [
                    'nombre_caja' => $this->nombre_caja,
                    'id_sucursal' => $this->id_sucursal,
                    'descripcion_caja' => $this->descripcion_caja,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa
                ]
            );

            session()->flash('success', 'Cajas actualizado correctamente.');

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarCaja($id)
    {
        $caja = Caja::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->id_caja = $caja->id_caja;
        $this->nombre_caja = $caja->nombre_caja;
        $this->id_sucursal = $caja->id_sucursal;
        $this->descripcion_caja = $caja->descripcion_caja;
        $this->id_estado = $caja->id_estado;
        $this->id_empresa = $caja->id_empresa;
    }

    public function resetInput()
    {
        $this->reset([
            'id_caja',
            'nombre_caja',
            'id_sucursal',
            'descripcion_caja',
            'id_estado',
            'id_empresa'
        ]);
    }

    public function render()
    {
        $cajas = Caja::where(function ($query) {
            $query->where('nombre_caja', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion_caja', 'like', '%' . $this->search . '%');
        })->paginate(10);

        $sucursales = Sucursal::all();
        $estados = Estado::all();
        $empresas = Empresa::all();

        return view('livewire.caja.index', [
            'cajas' => $cajas,
            'sucursales' => $sucursales,
            'estados' => $estados,
            'empresas' => $empresas
        ]);
    }
}
