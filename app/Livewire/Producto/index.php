<?php

namespace App\Livewire\Producto;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $producto_id;
    public $sk_producto;
    public $cod_barra;
    public $nombre_producto;
    public $descripcion_producto;
    public $id_marca;
    public $id_subcategoria;
    public $vencimiento;
    public $precio_compra;
    public $precio_venta;
    public $id_estado;
    public $id_empresa;
    public $id_sucursal;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'sk_producto' => 'required',
        'cod_barra' => 'required',
        'nombre_producto' => 'required',
        'descripcion_producto' => 'nullable',
        'id_marca' => 'required|integer',
        'id_subcategoria' => 'required|integer',
        'vencimiento' => 'required|date',
        'precio_compra' => 'required|numeric',
        'precio_venta' => 'required|numeric',
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
                    'sk_producto' => $this->sk_producto,
                    'cod_barra' => $this->cod_barra,
                    'nombre_producto' => $this->nombre_producto,
                    'descripcion_producto' => $this->descripcion_producto,
                    'id_marca' => $this->id_marca,
                    'id_subcategoria' => $this->id_subcategoria,
                    'vencimiento' => $this->vencimiento,
                    'precio_compra' => $this->precio_compra,
                    'precio_venta' => $this->precio_venta,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa,
                    'id_sucursal' => $this->id_sucursal,
                ]);

                session()->flash('success', 'Producto actualizado correctamente.');
            } else {
                // Crear producto
                Producto::create([
                    'sk_producto' => $this->sk_producto,
                    'cod_barra' => $this->cod_barra,
                    'nombre_producto' => $this->nombre_producto,
                    'descripcion_producto' => $this->descripcion_producto,
                    'id_marca' => $this->id_marca,
                    'id_subcategoria' => $this->id_subcategoria,
                    'vencimiento' => $this->vencimiento,
                    'precio_compra' => $this->precio_compra,
                    'precio_venta' => $this->precio_venta,
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
        $this->producto_id = $producto->id;
        $this->sk_producto = $producto->sk_producto;
        $this->cod_barra = $producto->cod_barra;
        $this->nombre_producto = $producto->nombre_producto;
        $this->descripcion_producto = $producto->descripcion_producto;
        $this->id_marca = $producto->id_marca;
        $this->id_subcategoria = $producto->id_subcategoria;
        $this->vencimiento = $producto->vencimiento;
        $this->precio_compra = $producto->precio_compra;
        $this->precio_venta = $producto->precio_venta;
        $this->id_estado = $producto->id_estado;
        $this->id_empresa = $producto->id_empresa;
        $this->id_sucursal = $producto->id_sucursal;
    }

    public function resetInput()
    {
        $this->reset([
            'producto_id',
            'sk_producto',
            'cod_barra',
            'nombre_producto',
            'descripcion_producto',
            'id_marca',
            'id_subcategoria',
            'vencimiento',
            'precio_compra',
            'precio_venta',
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
            'productos' => $productos
        ]);
    }
}
