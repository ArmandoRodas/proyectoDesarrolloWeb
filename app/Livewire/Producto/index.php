<?php

namespace App\Livewire\Producto;

use App\Models\Estado;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class index extends Component
{
    public $marcas = [];
    public $subCategorias = [];
    public $estados = [];

    use WithPagination;

    public $search = '';

    public $producto_id;
    public $sku_producto;
    public $cod_barra;
    public $nombre_producto;
    public $descripcion_producto;
    public $id_marca;
    public $id_subcategoria;
    public $vencimiento;
    public $precio_compra_producto;
    public $precio_venta_producto;
    public $id_estado;
    public $id_empresa;
    public $id_sucursal;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'sku_producto' => 'required',
        'cod_barra' => 'required',
        'nombre_producto' => 'required',
        'descripcion_producto' => 'nullable',
        'id_marca' => 'required|integer',
        'id_subcategoria' => 'required|integer',
        'vencimiento' => 'required|date',
        'precio_compra_producto' => 'required|numeric',
        'precio_venta_producto' => 'required|numeric',
        'id_estado' => 'required|integer',
        'id_empresa' => 'required|integer',
        'id_sucursal' => 'required|integer',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarProducto()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            if ($this->producto_id) {
                // Editar producto
                $producto = Producto::find($this->producto_id);

                $producto->update([
                    'sku_producto' => $this->sku_producto,
                    'cod_barra' => $this->cod_barra,
                    'nombre_producto' => $this->nombre_producto,
                    'descripcion_producto' => $this->descripcion_producto,
                    'id_marca' => $this->id_marca,
                    'id_subcategoria' => $this->id_subcategoria,
                    'vencimiento' => $this->vencimiento_producto,
                    'precio_compra_producto' => $this->precio_compra_producto,
                    'precio_venta_producto' => $this->precio_venta_producto,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa,
                    'id_sucursal' => $this->id_sucursal,
                ]);

                session()->flash('success', 'Producto actualizado correctamente.');
            } else {
                // Crear producto
                Producto::create([
                    'sku_producto' => $this->sku_producto,
                    'cod_barra' => $this->cod_barra,
                    'nombre_producto' => $this->nombre_producto,
                    'descripcion_producto' => $this->descripcion_producto,
                    'id_marca' => $this->id_marca,
                    'id_subcategoria' => $this->id_subcategoria,
                    'vencimiento' => $this->vencimiento_producto,
                    'precio_compra_producto' => $this->precio_compra_producto,
                    'precio_venta_producto' => $this->precio_venta_producto,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa,
                    'id_sucursal' => $this->id_sucursal,
                ]);

                session()->flash('success', 'Producto creado correctamente.');
            }

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();

        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }

    public function editarProducto($id)
    {
        $producto = Producto::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->producto_id = $producto->id_producto;
        $this->sku_producto = $producto->sku_producto;
        $this->cod_barra = $producto->cod_barra;
        $this->nombre_producto = $producto->nombre_producto;
        $this->descripcion_producto = $producto->descripcion_producto;
        $this->id_marca = $producto->id_marca;
        $this->id_subcategoria = $producto->id_subcategoria;
        $this->vencimiento = $producto->vencimiento_producto;
        $this->precio_compra_producto = $producto->precio_compra_producto;
        $this->precio_venta_producto = $producto->precio_venta_producto;
        $this->id_estado = $producto->id_estado;
        $this->id_empresa = $producto->id_empresa;
        $this->id_sucursal = $producto->id_sucursal;

//        dd($producto);
    }

    public function resetInput()
    {
        $this->reset([
            'producto_id',
            'sku_producto',
            'cod_barra',
            'nombre_producto',
            'descripcion_producto',
            'id_marca',
            'id_subcategoria',
            'vencimiento',
            'precio_compra_producto',
            'precio_venta_producto',
            'id_estado',
            'id_empresa',
            'id_sucursal'
        ]);
    }

    public function render()
    {
        $productos = Producto::where(function ($query) {
            $query->where('nombre_producto', 'like', '%' . $this->search . '%')
                ->orWhere('cod_barra', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.producto.index', [
            'productos' => $productos,
            'marcas' => $this->marcas,
            'subCategorias' => $this->subCategorias,
            'estados' => $this->estados
        ]);
    }

    public function mount()
    {
        $this->marcas = Marca::all();
        $this->subCategorias = SubCategoria::all();
        $this->estados = Estado::all();
    }
}
