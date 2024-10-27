<?php

namespace App\Livewire\Caja;

use App\Models\AperturaCaja as ModelsAperturaCaja;
use App\Models\Caja;
use App\Models\DetalleAperturaCaja;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AperturaCaja extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $id_apertura_caja;
    public $id_caja;
    public $saldo_inicial_caja;
    public $descripcion_apertura_caja;
    public $id_estado = 3; // Abierto

    public $search = '';

    public $rules = 
    [
        'saldo_inicial_caja' => 'required',
        'descripcion_apertura_caja' => 'nullable|max:75',
        'id_caja' => 'required'
    ];

    public function guardarApertura()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            // Verificar si la caja ya ha sido aperturada previamente (estado 3 = Abierto)
            $aperturaExistente = ModelsAperturaCaja::where('id_caja', $this->id_caja)
                ->where('id_estado', 3) // Estado "Abierto"
                ->when($this->id_apertura_caja, function($query) {
                    // Omitir la verificación si es la misma apertura que se está editando
                    return $query->where('id_apertura_caja', '!=', $this->id_apertura_caja);
                })
                ->first();

            if ($aperturaExistente) {
                // Mostrar mensaje de que la caja ya está aperturada
                session()->flash('error', 'La caja ya ha sido aperturada previamente.');

                // Reiniciar los campos
                $this->resetInput();
                return;
            }

            $aperturaCaja = ModelsAperturaCaja::updateOrCreate(
                ['id_apertura_caja' => $this->id_apertura_caja],
                [
                    'saldo_inicial_caja' => $this->saldo_inicial_caja,
                    'descripcion_apertura_caja' => $this->descripcion_apertura_caja,
                    'id_caja' => $this->id_caja,
                    'id_estado' => $this->id_estado
                ]
            );

            // Verificar si la apertura fue creada o actualizada
            if ($aperturaCaja->wasRecentlyCreated) {
                
                // Registrar movimiento en la caja
                DetalleAperturaCaja::updateOrCreate([
                    'id_apertura_caja' => $aperturaCaja->id_apertura_caja,
                    'tipo_movimiento' => 'Ingreso',
                    'monto_det_apertura_caja' => $aperturaCaja->saldo_inicial_caja,
                    'descripcion_movimiento' => 'Saldo inicial Q.' . $aperturaCaja->saldo_inicial_caja . ' - ' . $aperturaCaja->caja->nombre_caja
                ]);
            }

            session()->flash('success', 'Apertura actualizada correctamente.');

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            session()->flash('error', $th->getMessage());
            
            // Reiniciar los campos
            $this->resetInput();
        }
    }

    public function editarApertura($id)
    {
        $aperturaCaja = ModelsAperturaCaja::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->id_apertura_caja = $aperturaCaja->id_apertura_caja;
        $this->id_caja = $aperturaCaja->id_caja;
        $this->saldo_inicial_caja = $aperturaCaja->saldo_inicial_caja;
        $this->descripcion_apertura_caja = $aperturaCaja->descripcion_apertura_caja;
    }

    public function resetInput()
    {
        $this->reset([
            'id_apertura_caja',
            'id_caja',
            'saldo_inicial_caja',
            'descripcion_apertura_caja'
        ]);
    }

    public function render()
    {
        $aperturasCajas = ModelsAperturaCaja::where(function ($query) {
            $query->where('descripcion_apertura_caja', 'like', '%' . $this->search . '%')
                ->orWhereHas('caja', function ($query) {
                    $query->where('nombre_caja', 'like', '%' . $this->search . '%');
                });
        })->paginate(10);

        $cajas = Caja::all();

        return view('livewire.caja.apertura-caja', [
            'aperturasCajas' => $aperturasCajas,
            'cajas' => $cajas
        ]);
    }
}
