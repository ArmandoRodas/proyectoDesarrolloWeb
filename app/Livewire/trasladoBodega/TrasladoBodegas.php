<?php
namespace App\Livewire\trasladoBodega;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Bodega;
use App\Models\BodegaProducto;
use App\Models\Traslado;
use App\Models\TrasladoDetalle;
use Livewire\WithPagination;

class TrasladoBodegas extends Component
{
    public $bodegaOrigen;
    public $bodegaDestino;
    public $productos = [];
    public $cantidadTraslado = [];

    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function actualizarBodegaOrigen($bodegaId)
    {
        $this->bodegaOrigen = $bodegaId;

        if ($this->bodegaOrigen) {
            $this->productos = BodegaProducto::where('id_bodega', $this->bodegaOrigen)
                ->with('producto')
                ->get();
        } else {
            $this->productos = [];
        }
    }

    public function realizarTraslado()
    {
        if (!$this->bodegaOrigen || !$this->bodegaDestino) {
            session()->flash('error', 'Debe seleccionar tanto la bodega de origen como la de destino.');
            return;
        }

        if (empty($this->cantidadTraslado)) {
            session()->flash('error', 'Debe ingresar cantidades para trasladar.');
            return;
        }

        DB::beginTransaction();

        try {
            // Verificación del stock antes del traslado
            foreach ($this->productos as $producto) {
                $cantidad = $this->cantidadTraslado[$producto->producto->id_producto] ?? 0;

                // Obtener el stock en la bodega de origen
                $bodegaProductoOrigen = BodegaProducto::where('id_bodega', $this->bodegaOrigen)
                    ->where('id_producto', $producto->producto->id_producto)
                    ->lockForUpdate() // Bloquear la fila para evitar cambios concurrentes
                    ->first();

                // Verificar que el stock sea mayor que 0 y que la cantidad solicitada no supere el stock
                if (!$bodegaProductoOrigen || $bodegaProductoOrigen->stock_producto <= 0) {
                    throw new \Exception("El producto {$producto->producto->nombre_producto} no tiene suficiente stock en la bodega de origen.");
                }

                if ($cantidad > $bodegaProductoOrigen->stock_producto) {
                    throw new \Exception("La cantidad solicitada para el producto {$producto->producto->nombre_producto} supera el stock disponible.");
                }
            }

            $traslado = Traslado::create([
                'fecha_traslado' => now(),
                'descripcion_traslado' => 'Traslado de productos entre bodegas',
                'documento_traslado' => 'TR-' . now()->timestamp,
                'id_bodega_origen' => $this->bodegaOrigen,
                'id_bodega_destino' => $this->bodegaDestino,
                'id_usuario' => auth()->user()->id_usuario,
                'id_empresa' => auth()->user()->id_empresa,
                'id_estado' => 1,
            ]);

            // Procesar los detalles del traslado y actualizar stock en origen y destino
            foreach ($this->productos as $producto) {
                $cantidad = $this->cantidadTraslado[$producto->producto->id_producto] ?? 0;

                if ($cantidad > 0) {
                    TrasladoDetalle::create([
                        'id_traslado' => $traslado->id,
                        'id_producto' => $producto->producto->id_producto,
                        'cantidad_trasladar' => $cantidad,
                    ]);

                    // 1. Actualizar el stock en la bodega de origen
                    $bodegaProductoOrigen->stock_producto -= $cantidad;
                    $bodegaProductoOrigen->save();

                    // 2. Actualizar o crear el producto en la bodega de destino
                    $bodegaProductoDestino = BodegaProducto::where('id_bodega', $this->bodegaDestino)
                        ->where('id_producto', $producto->producto->id_producto)
                        ->lockForUpdate()
                        ->first();

                    // Si el producto existe en la bodega destino, actualizamos su stock
                    if ($bodegaProductoDestino) {
                        $bodegaProductoDestino->stock_producto += $cantidad;
                        $bodegaProductoDestino->save();
                    } else {
                        BodegaProducto::create([
                            'id_bodega' => $this->bodegaDestino,
                            'id_producto' => $producto->producto->id_producto,
                            'stock_producto' => $cantidad,
                            'stock_min_producto' => 0,
                            'stock_max_producto' => 1000,
                        ]);
                    }
                }
            }

            DB::commit();

            session()->flash('message', 'Traslado realizado con éxito.');
            return redirect()->route('traslados.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return;
        }
    }

    public function render()
    {
        $productosPaginados = new LengthAwarePaginator([], 0, 10);

        if ($this->bodegaOrigen) {
            $productosQuery = BodegaProducto::where('id_bodega', $this->bodegaOrigen)
                ->with('producto');

            if ($this->search) {
                $productosQuery->whereHas('producto', function($query) {
                    $query->where('nombre_producto', 'like', '%' . $this->search . '%')
                        ->orWhere('sku_producto', 'like', '%' . $this->search . '%')
                        ->orWhere('cod_barra', 'like', '%' . $this->search . '%');
                });
            }

            $productosPaginados = $productosQuery->paginate(10);
        }

        return view('livewire.trasladoBodega.index', [
            'bodegas' => Bodega::all(),
            'productosPaginados' => $productosPaginados
        ]);
    }
}
