<?php

namespace App\Livewire\Cliente;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $cliente_id;
    public $codigo_cliente;
    public $nombre_cliente;
    public $nit_cliente;
    public $direccion_cliente;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo_cliente' => 'required',
        'nombre_cliente' => 'required',
        'nit_cliente' => 'required',
        'direccion_cliente' => 'required',
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

            if ($this->cliente_id) {
                // Editar cliente
                $cliente = Cliente::find($this->cliente_id);

                $cliente->update([
                    'codigo_cliente' => $this->codigo_cliente,
                    'nombre_cliente' => $this->nombre_cliente,
                    'nit_cliente' => $this->nit_cliente,
                    'direccion_cliente' => $this->direccion_cliente,
                ]);

                session()->flash('success', 'Cliente actualizado correctamente.');
            } else {
                // Crear cliente
                Cliente::create([
                    'codigo_cliente' => $this->codigo_cliente,
                    'nombre_cliente' => $this->nombre_cliente,
                    'nit_cliente' => $this->nit_cliente,
                    'direccion_cliente' => $this->direccion_cliente,
                ]);

                session()->flash('success', 'Cliente creado correctamente.');
            }

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
        $cliente = Cliente::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->cliente_id = $cliente->id;
        $this->codigo_cliente = $cliente->codigo_cliente;
        $this->nombre_cliente = $cliente->nombre_cliente;
        $this->nit_cliente = $cliente->nit_cliente;
        $this->direccion_cliente = $cliente->direccion_cliente;
    }

    public function resetInput()
    {
        $this->reset([
            'cliente_id',
            'codigo_cliente',
            'nombre_cliente',
            'nit_cliente',
            'direccion_cliente'
        ]);
    }

    public function render()
    {
        $clientes = Cliente::where(function ($query) {
            $query->where('nombre_cliente', 'like', '%' . $this->search . '%')
                ->orWhere('codigo_cliente', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.cliente.index', [
            'clientes' => $clientes
        ]);
    }
}
