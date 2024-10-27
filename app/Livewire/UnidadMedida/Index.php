<?php 

namespace App\Livewire\UnidadMedida;

use App\Models\UnidadMedida;
use App\Models\Estado;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estado_filter = '';
    public $id_unidad_medida, $codigo_unidad_medida, $nombre_unidad_medida, $id_estado, $codigo_siguiente;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo_unidad_medida' => 'required|max:4',
        'nombre_unidad_medida' => 'required|max:15',
        'id_estado' => 'required'
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedEstadoFilter()
    {
        $this->resetPage();
    }

    // Cargar datos de la unidad de medida para edición
    public function editarUnidadMedida($id)
    {
        $unidadMedida = UnidadMedida::findOrFail($id);

        $this->id_unidad_medida = $unidadMedida->id_unidad_medida;
        $this->codigo_unidad_medida = $unidadMedida->codigo_unidad_medida;
        $this->nombre_unidad_medida = $unidadMedida->nombre_unidad_medida;
        $this->id_estado = $unidadMedida->id_estado;
        $this->codigo_siguiente = $unidadMedida->codigo_unidad_medida;
    }

    public function guardarUnidadMedida()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            $codigo_unidad_medida = $this->id_unidad_medida
                ? UnidadMedida::find($this->id_unidad_medida)->codigo_unidad_medida
                : strtoupper(substr($this->nombre_unidad_medida, 0, 4));

            $unidadMedida = UnidadMedida::updateOrCreate(
                ['id_unidad_medida' => $this->id_unidad_medida],
                [
                    'codigo_unidad_medida' => $codigo_unidad_medida,
                    'nombre_unidad_medida' => $this->nombre_unidad_medida,
                    'id_estado' => $this->id_estado,
                ]
            );

            session()->flash('success', $this->id_unidad_medida ? 'Unidad de medida actualizada correctamente.' : 'Unidad de medida creada correctamente.');

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
            'id_unidad_medida',
            'codigo_unidad_medida',
            'nombre_unidad_medida',
            'id_estado',
            'codigo_siguiente'
        ]);
    }

    public function render()
    {
        $unidadesMedida = UnidadMedida::query()
            ->when($this->estado_filter, function ($query) {
                $query->where('id_estado', $this->estado_filter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nombre_unidad_medida', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo_unidad_medida', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        $estados = Estado::all();

        return view('livewire.unidad-medida.index', [
            'unidadesMedida' => $unidadesMedida,
            'estados' => $estados
        ]);
    }
}
