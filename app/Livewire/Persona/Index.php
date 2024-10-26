<?php

namespace App\Livewire\Persona;

use App\Models\Persona;
use App\Models\Estado;
use App\Models\TipoPersona;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tipo_persona_filter = '';
    public $estado_filter = '';
    public $id_persona, $nombre_persona, $direccion_persona, $telefono_persona, $correo_persona;
    public $nit_persona, $cui_persona, $id_tipo_persona, $id_estado, $codigo_siguiente;

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

    public function updatedTipoPersonaFilter()
    {
        $this->resetPage();
    }

    public function updatedEstadoFilter()
    {
        $this->resetPage();
    }

    // Cargar datos de la persona para edición
    public function editarPersona($id)
    {
        $persona = Persona::findOrFail($id);

        $this->id_persona = $persona->id_persona;
        $this->nombre_persona = $persona->nombre_persona;
        $this->direccion_persona = $persona->direccion_persona;
        $this->telefono_persona = $persona->telefono_persona;
        $this->correo_persona = $persona->correo_persona;
        $this->nit_persona = $persona->nit_persona;
        $this->cui_persona = $persona->cui_persona;
        $this->id_tipo_persona = $persona->id_tipo_persona;
        $this->id_estado = $persona->id_estado;
        $this->codigo_siguiente = $persona->codigo_persona; // Cargar el código actual de la persona
    }

    public function guardarPersona()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            $tipoPersona = $this->id_persona ? null : TipoPersona::find($this->id_tipo_persona);

            $codigo_persona = $this->id_persona
                ? Persona::find($this->id_persona)->codigo_persona
                : $tipoPersona->serie_persona . '-' . str_pad($tipoPersona->secuencia_persona + 1, 5, '0', STR_PAD_LEFT);

            $persona = Persona::updateOrCreate(
                ['id_persona' => $this->id_persona],
                [
                    'codigo_persona' => $codigo_persona,
                    'nombre_persona' => $this->nombre_persona,
                    'direccion_persona' => $this->direccion_persona,
                    'telefono_persona' => $this->telefono_persona,
                    'correo_persona' => $this->correo_persona,
                    'nit_persona' => $this->nit_persona,
                    'cui_persona' => $this->cui_persona,
                    'id_tipo_persona' => $this->id_persona ? Persona::find($this->id_persona)->id_tipo_persona : $this->id_tipo_persona,
                    'id_estado' => $this->id_estado,
                ]
            );

            if (!$this->id_persona && $tipoPersona) {
                $tipoPersona->update(['secuencia_persona' => $tipoPersona->secuencia_persona + 1]);
            }

            session()->flash('success', $this->id_persona ? 'Persona actualizada correctamente.' : 'Persona creada correctamente.');

            DB::commit();

            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function resetInput()
    {
        $this->reset([
            'id_persona',
            'nombre_persona',
            'direccion_persona',
            'telefono_persona',
            'correo_persona',
            'nit_persona',
            'cui_persona',
            'id_tipo_persona',
            'id_estado',
            'codigo_siguiente'
        ]);
    }

    public function render()
    {
        $personas = Persona::query()
            ->when($this->tipo_persona_filter, function ($query) {
                $query->where('id_tipo_persona', $this->tipo_persona_filter);
            })
            ->when($this->estado_filter, function ($query) {
                $query->where('id_estado', $this->estado_filter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre_persona', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo_persona', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        $tiposDePersonas = TipoPersona::all();
        $estados = Estado::all();

        return view('livewire.persona.index', [
            'personas' => $personas,
            'tiposDePersonas' => $tiposDePersonas,
            'estados' => $estados
        ]);
    }
}
