<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $id_persona;
    public $nombre_persona;
    public $direccion_persona;
    public $telefono_persona;
    public $correo_persona;
    public $nit_persona;
    public $cui_persona;
    public $id_tipo_persona;
    public $id_estado;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nombre_persona' => 'required',
        'direccion_persona' => 'required',
        'telefono_persona' => 'required',
        'correo_persona' => 'nullable|email',
        'nit_persona' => 'required',
        'cui_persona' => 'required',
        'id_tipo_persona' => 'required',
        'id_estado' => 'required'
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarCliente()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            $cliente = Persona::find($this->id_persona);
            $id_cliente = $cliente->id_persona ?? null;

            // Calcular codigo del cliente
            if($id_cliente)
            {
                $codigo_cliente = $cliente->codigo_persona;
            }else{
                $codigo = Persona::count() + 1;
                $codigo_cliente = 'C-' . str_pad($codigo, 5, '0', STR_PAD_LEFT);
            }

            Persona::updateOrCreate(
                ['id_persona' => $id_cliente],
                [
                    'codigo_persona' => $codigo_cliente,
                    'nombre_persona' => $this->nombre_persona,
                    'direccion_persona' => $this->direccion_persona,
                    'telefono_persona' => $this->telefono_persona,
                    'correo_persona' => $this->correo_persona,
                    'nit_persona' => $this->nit_persona,
                    'cui_persona' => $this->cui_persona,
                    'id_tipo_persona' => $this->id_tipo_persona,
                    'id_estado' => $this->id_estado
                ]
            );

            session()->flash('success', 'Cliente actualizado correctamente.');

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarCliente($id)
    {
        $cliente = Persona::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->id_persona = $cliente->id_persona;
        $this->nombre_persona = $cliente->nombre_persona;
        $this->direccion_persona = $cliente->direccion_persona;
        $this->telefono_persona = $cliente->telefono_persona;
        $this->correo_persona = $cliente->correo_persona;
        $this->nit_persona = $cliente->nit_persona;
        $this->cui_persona = $cliente->cui_persona;
        $this->id_tipo_persona = $cliente->id_tipo_persona;
        $this->id_estado = $cliente->id_estado;
    }

    public function resetInput()
    {
        $this->reset([
            'nombre_persona',
            'direccion_persona',
            'telefono_persona',
            'correo_persona',
            'nit_persona',
            'cui_persona',
            'id_tipo_persona',
            'id_estado'
        ]);
    }

    public function render()
    {
        $clientes = Persona::where(function ($query) {
            $query->where('nombre_persona', 'like', '%' . $this->search . '%')
                ->orWhere('codigo_persona', 'like', '%' . $this->search . '%');
        })->paginate(10);

        $tiposDePersonas = TipoPersona::all();
        $estados = Estado::all();

        return view('livewire.cliente.index', [
            'clientes' => $clientes,
            'tiposDePersonas' => $tiposDePersonas,
            'estados' => $estados
        ]);
    }
}
