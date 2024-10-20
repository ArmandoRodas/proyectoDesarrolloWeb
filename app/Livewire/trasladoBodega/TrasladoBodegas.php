<?php
namespace App\Livewire\trasladoBodega;

use Livewire\Component;
use App\Models\Bodega;
use App\Models\BodegaProducto;
use App\Models\Traslado;
use App\Models\TrasladoDetalle;

class TrasladoBodegas extends Component
{
    public $bodegaOrigen;
    public $bodegaDestino;
    public $productos = [];
    public $cantidadTraslado = [];

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

    // Método para realizar el traslado
    public function realizarTraslado()
    {
        if (!$this->bodegaOrigen || !$this->bodegaDestino) {
            session()->flash('error', 'Debe seleccionar tanto la bodega de origen como la de destino.');
            return;
        }

        // Verificamos que se haya seleccionado algún producto para trasladar
        if (empty($this->cantidadTraslado)) {
            session()->flash('error', 'Debe ingresar cantidades para trasladar.');
            return;
        }

        // Crear el traslado principal
        $traslado = Traslado::create([
            'fecha_traslado' => now(),
            'descripcion_traslado' => 'Traslado de productos entre bodegas',
            'documento_traslado' => 'TR-' . now()->timestamp,
            'id_bodega_origen' => $this->bodegaOrigen,
            'id_bodega_destino' => $this->bodegaDestino,
            'id_usuario' => 1, /*auth()->user()->id,*/
            'id_empresa' => 1, /*auth()->user()->empresa_id,*/
            'id_estado' => 1,
        ]);

        // Procesar los detalles del traslado (productos)
        foreach ($this->productos as $producto) {
            $cantidad = $this->cantidadTraslado[$producto->producto->id] ?? 0;

            if ($cantidad > 0) {
                // Crear el detalle del traslado
                TrasladoDetalle::create([
                    'id_traslado' => $traslado->id,
                    'id_producto' => $producto->producto->id,
                    'cantidad_trasladar' => $cantidad,
                ]);

                // Actualizar el stock en la bodega de origen
                $bodegaProductoOrigen = BodegaProducto::where('id_bodega', $this->bodegaOrigen)
                    ->where('id_producto', $producto->producto->id)
                    ->first();
                $bodegaProductoOrigen->stock_producto -= $cantidad;
                $bodegaProductoOrigen->save();

                // Actualizar el stock en la bodega de destino
                $bodegaProductoDestino = BodegaProducto::where('id_bodega', $this->bodegaDestino)
                    ->where('id_producto', $producto->producto->id)
                    ->first();

                if ($bodegaProductoDestino) {
                    $bodegaProductoDestino->stock_producto += $cantidad;
                    $bodegaProductoDestino->save();
                } else {
                    // Si no existe el producto en la bodega de destino, lo creamos
                    BodegaProducto::create([
                        'id_bodega' => $this->bodegaDestino,
                        'id_producto' => $producto->producto->id,
                        'stock_producto' => $cantidad,
                        'stock_min_producto' => 0,
                        'stock_max_producto' => 1000,
                    ]);
                }
            }
        }

        session()->flash('message', 'Traslado realizado con éxito.');
        return redirect()->route('traslados.index');
    }

    public function render()
    {
        return view('livewire.trasladoBodega.index', [
            'bodegas' => Bodega::all()
        ]);
    }
}
