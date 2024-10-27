<?php

namespace App\Livewire\Producto;

use App\Models\BodegaProducto;
use App\Models\Estado;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Subcategoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class index extends Component
{
    public $marcas = [];
    public $subCategorias = [];
    public $estados = [];

    public $bodegas = [];

    public $stocks = [];

    use WithPagination;

    public $search = '';

    public $producto_id;
    public $sku_producto;
    public $cod_barra;
    public $nombre_producto;
    public $descripcion_producto;
    public $id_marca;
    public $id_subcategoria;
    public $vencimiento_producto;
    public $precio_compra_producto;
    public $precio_venta_producto;
    public $id_estado;
    public $id_empresa;
    public $id_sucursal;

    public $id_bodega;
    public $stock_producto;


    protected $rules = [
        'sku_producto' => 'required',
        'cod_barra' => 'required',
        'nombre_producto' => 'required',
        'descripcion_producto' => 'nullable',
        'id_marca' => 'required|integer',
        'id_subcategoria' => 'required|integer',
        'vencimiento_producto' => 'required|date',
        'precio_compra_producto' => 'required|numeric',
        'precio_venta_producto' => 'required|numeric',
        'id_estado' => 'required|integer',
//        'id_empresa' => 'required|integer',
//        'id_sucursal' => 'required|integer',
    ];

    protected $paginationTheme = 'bootstrap';

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
                    'vencimiento_producto' => $this->vencimiento_producto,
                    'precio_compra_producto' => $this->precio_compra_producto,
                    'precio_venta_producto' => $this->precio_venta_producto,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa,
                    'id_sucursal' => $this->id_sucursal,
                ]);

                foreach ($this->stocks as $stock) {
                    $this->guardarStock($producto->id_producto, $stock['stock_producto'], $stock['id_bodega']);
                }
                session()->flash('success', 'Producto actualizado correctamente.');
            } else {
                // Crear producto
               $producto = Producto::create([
                    'sku_producto' => $this->sku_producto,
                    'cod_barra' => $this->cod_barra,
                    'nombre_producto' => $this->nombre_producto,
                    'descripcion_producto' => $this->descripcion_producto,
                    'id_marca' => $this->id_marca,
                    'id_subcategoria' => $this->id_subcategoria,
                    'vencimiento_producto' => $this->vencimiento_producto,
                    'precio_compra_producto' => $this->precio_compra_producto,
                    'precio_venta_producto' => $this->precio_venta_producto,
                    'id_estado' => $this->id_estado,
                    'id_empresa' => $this->id_empresa,
                    'id_sucursal' => $this->id_sucursal,
                ]);

                if ($producto) {
                    foreach ($this->stocks as $stock) {
                        $this->guardarStock($producto->id_producto, $stock['stock_producto'], $stock['id_bodega']);
                    }
                }

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

    protected function guardarStock($producto_id, $cantidad, $bodega_id)
    {
        return BodegaProducto::updateOrCreate(
            ['id_producto' => $producto_id, 'id_bodega' => $bodega_id],
            [
                'stock_producto' => $cantidad,
                'stock_min_producto' => 0,
                'stock_max_producto' => 100,
            ]
        );
    }

    public function editarProducto($id)
    {
        $producto = Producto::with('bodegaProducto')->findOrFail($id);

        $this->producto_id = $producto->id_producto;
        $this->sku_producto = $producto->sku_producto;
        $this->cod_barra = $producto->cod_barra;
        $this->nombre_producto = $producto->nombre_producto;
        $this->descripcion_producto = $producto->descripcion_producto;
        $this->id_marca = $producto->id_marca;
        $this->id_subcategoria = $producto->id_subcategoria;
        $this->vencimiento_producto = $producto->vencimiento_producto;
        $this->precio_compra_producto = $producto->precio_compra_producto;
        $this->precio_venta_producto = $producto->precio_venta_producto;
        $this->id_estado = $producto->id_estado;
        $this->id_empresa = $producto->id_empresa;
        $this->id_sucursal = $producto->id_sucursal;

        $this->stocks = $producto->bodegaProducto->map(function($bodegaProducto) {
            return [
                'id_bodega' => $bodegaProducto->id_bodega,
                'stock_producto' => $bodegaProducto->stock_producto
            ];
        })->toArray();
    }

    public function addStockRow()
    {
        $this->stocks[] = ['id_bodega' => null, 'stock_producto' => 0];
    }

    public function removeStockRow($index)
    {
        unset($this->stocks[$index]);
        $this->stocks = array_values($this->stocks);
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
            'vencimiento_producto',
            'precio_compra_producto',
            'precio_venta_producto',
            'id_estado',
            'id_empresa',
            'id_sucursal',
            'stocks',
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
            'estados' => $this->estados,
            'bodegas' => $this->bodegas,
        ]);
    }

    public function mount()
    {
        $this->marcas = Marca::all();
        $this->subCategorias = Subcategoria::all();
        $this->estados = Estado::all();
        $this->bodegas = BodegaProducto::all();
    }
}
