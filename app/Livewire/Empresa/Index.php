<?php

namespace App\Livewire\Empresa;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $id_empresa;
    public $nombre_empresa;
    public $NIT_empresa;
    public $direccion_empresa;
    public $telefono_empresa;
    public $email_empresa;

    public $id_pais;
    public $id_departamento;
    public $id_municipio;
    public $id_estado;

    protected $rules = [
        'nombre_empresa' => 'required',
        'NIT_empresa' => 'required|integer',
        'direccion_empresa' => 'required',
        'telefono_empresa' => 'required',
        'email_empresa' => 'nullable|email'
    ];

    public function mount()
    {
        // Inicializar la propiedad con el valor de la configuración
        $this->id_empresa = config('id_empresa');
        $this->nombre_empresa = config('nombre_empresa');
        $this->NIT_empresa = config('NIT_empresa');
        $this->direccion_empresa = config('direccion_empresa');
        $this->telefono_empresa = config('telefono_empresa');
        $this->email_empresa = config('email_empresa');

        $this->id_pais = config('id_pais');
        $this->id_departamento = config('id_departamento');
        $this->id_municipio = config('id_municipio');
        $this->id_estado = config('id_estado');
    }

    public function guardarEmpresa()
    {
        $data = [
            'nombre_empresa' => $this->nombre_empresa,
            'NIT_empresa' => $this->NIT_empresa,
            'direccion_empresa' => $this->direccion_empresa,
            'telefono_empresa' => $this->telefono_empresa,
            'email_empresa' => $this->email_empresa,
            'id_pais' => $this->id_pais,
            'id_departamento' => $this->id_departamento,
            'id_municipio' => $this->id_municipio,
            'id_estado' => $this->id_estado,
        ];

        DB::beginTransaction();
        
        try {
            $this->validate();

            $empresa = Empresa::updateOrCreate(
                ['id_empresa' => $this->id_empresa],
                $data
            );

            DB::commit();

            session()->flash('success', 'Datos de la empresa actualizados exitosamente.');

            $this->reset();
            
            // Asignar valores a los inputs
            $this->id_empresa = $empresa->id_empresa;
            $this->nombre_empresa = $empresa->nombre_empresa;
            $this->NIT_empresa = $empresa->NIT_empresa;
            $this->direccion_empresa = $empresa->direccion_empresa;
            $this->telefono_empresa = $empresa->telefono_empresa;
            $this->email_empresa = $empresa->email_empresa;
            $this->id_pais = $empresa->id_pais;
            $this->id_departamento = $empresa->id_departamento;
            $this->id_municipio = $empresa->id_municipio;
            $this->id_estado = $empresa->id_estado;

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar los datos de la empresa: ' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.empresa.index');
    }
}
