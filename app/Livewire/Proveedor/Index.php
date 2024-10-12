<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedores;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $proveedor_id;
    public $codigo_proveedor;
    public $nombre_proveedor;
    public $nit_proveedor;
    public $direccion_proveedor;
    public $telefono_proveedor;
    public $correo_proveedor;
    public $cui_proveedor;
    public $estado_proveedor;

    protected $rules = [
        'codigo_proveedor' => 'required',
        'nombre_proveedor' => 'required',
        'nit_proveedor' => 'required',
        'direccion_proveedor' => 'required',
        'telefono_proveedor' => 'required',
        'correo_proveedor' => 'required',
        'cui_proveedor' => 'required',
        'estado_proveedor' => 'required'
    ];

    public function render()
    {
        $proveedor = Proveedores::where(function ($query) {
            $query->where('codigo_proveedor', 'like', '%' . $this->search . '%')
                ->orWhere('nombre_proveedor', 'like', '%' . $this->search . '%')
                ->orWhere('nit_proveedor', 'like', '%' . $this->search . '%');
        })->paginate(10);
        return view('livewire.proveedor.index', [
            'proveedor' => $proveedor
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset([
            'codigo_proveedor',
            'nombre_proveedor',
            'nit_proveedor',
            'direccion_proveedor',
            'telefono_proveedor',
            'correo_proveedor',
            'cui_proveedor'
        ]);
        $this->estado_proveedor = 1;
    }

    public function guardar()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            if ($this->proveedor_id) {
                $proveedor = Proveedores::find($this->proveedor_id);
                $proveedor->update([
                    'codigo_proveedor' => $this->codigo_proveedor,
                    'nombre_proveedor' => $this->nombre_proveedor,
                    'nit_proveedor' => $this->nit_proveedor,
                    'direccion_proveedor' => $this->direccion_proveedor,
                    'telefono_proveedor' => $this->telefono_proveedor,
                    'correo_proveedor' => $this->correo_proveedor,
                    'cui_proveedor' => $this->cui_proveedor,
                    'estado_proveedor' => $this->estado_proveedor
                ]);
                session()->flash('success', 'Proveedor actualizado correctamente.');
            } else {
                Proveedores::create([
                    'codigo_proveedor' => $this->codigo_proveedor,
                    'nombre_proveedor' => $this->nombre_proveedor,
                    'nit_proveedor' => $this->nit_proveedor,
                    'direccion_proveedor' => $this->direccion_proveedor,
                    'telefono_proveedor' => $this->telefono_proveedor,
                    'correo_proveedor' => $this->correo_proveedor,
                    'cui_proveedor' => $this->cui_proveedor,
                    'estado_proveedor' => $this->estado_proveedor
                ]);
                session()->flash('success', 'Proveedor creado correctamente.');
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
        $proveedor = Proveedores::findOrFail($id);
        $this->proveedor_id = $proveedor->id;
        $this->codigo_proveedor = $proveedor->codigo_proveedor;
        $this->nombre_proveedor = $proveedor->nombre_proveedor;
        $this->nit_proveedor = $proveedor->nit_proveedor;
        $this->direccion_proveedor = $proveedor->direccion_proveedor;
        $this->telefono_proveedor = $proveedor->telefono_proveedor;
        $this->correo_proveedor = $proveedor->correo_proveedor;
        $this->cui_proveedor = $proveedor->cui_proveedor;
        $this->estado_proveedor = $proveedor->estado_proveedor;
    }
}
