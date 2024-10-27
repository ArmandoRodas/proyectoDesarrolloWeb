<?php

namespace App\Livewire\Venta;

use App\Models\AperturaCaja;
use App\Models\Bodega;
use App\Models\CuentaPorCobrar;
use App\Models\DetalleAperturaCaja;
use App\Models\MetodoPago;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\TipoDocumento;
use App\Models\TipoVenta;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NuevoDocumento extends Component
{
    public $id_tipo_documento;
    public $id_medio_pago;
    public $id_tipoVenta;
    public $dias_credito;

    // Carrito de ventas
    public $cartItems = [];
    public $subtotal = 0;

    public function mount()
    {
        $this->cartItems = Cart::instance('ventas')->content()->toArray();
    }

    // Cliente
    public $codigo_cliente;
    public $id_cliente;

    // Buscar Cliente
    public $searchTermCliente = '';
    public $selectedCliente = null;
    public $showDropdownCliente = false;

    
    public function toggleDropdownCliente()
    {
        $this->showDropdownCliente = !$this->showDropdownCliente;
    }
    
    public function selectCliente($clienteId)
    {
        $this->selectedCliente = Persona::find($clienteId);
        $this->searchTermCliente = $this->selectedCliente->nombre_persona;
        $this->codigo_cliente = $this->selectedCliente->codigo_persona;
        $this->id_cliente = $this->selectedCliente->id_persona;
        $this->showDropdownCliente = false;
    }
    
    // Buscar Producto
    public $searchTermProducto = '';
    public $selectedProducto = null;
    public $showDropdownProducto = false;

    public function toggleDropdownProducto()
    {
        $this->showDropdownProducto = !$this->showDropdownProducto;
    }

    public function selectProducto($productoId)
    {
        $this->selectedProducto = Producto::find($productoId);
        $this->searchTermProducto = '';
        $this->showDropdownProducto = false;

        $this->agregarAlCarrito($productoId);
    }

    // Carrito de Ventas
    public function agregarAlCarrito($productoId)
    {
        $producto = Producto::find($productoId);
        $bodegaDefault = Bodega::find(1);

        Cart::instance('ventas')->add([
            'id' => $productoId,
            'name' => $producto->nombre_producto,
            'qty' => 1,
            'price' => $producto->precio_venta_producto,
            'options' => [
                'sku_producto' => $producto->sku_producto,
                'precio_compra' => $producto->precio_compra_producto,
                'id_bodega' => $bodegaDefault->id_bodega,
                'nombre_bodega' => $bodegaDefault->nombre_bodega,
            ]
        ]);

        $this->cartItems = Cart::instance('ventas')->content()->toArray();
    }

    public function actualizarQtyProducto($rowId, $cantidad_venta_detalle)
    {
        if (is_numeric($cantidad_venta_detalle) && $cantidad_venta_detalle > 0) {
            Cart::instance('ventas')->update($rowId, $cantidad_venta_detalle);
        }

        $this->cartItems = Cart::instance('ventas')->content()->toArray();
    }

    public function eliminarProducto($rowId)
    {
        Cart::instance('ventas')->remove($rowId);

        $this->cartItems = Cart::instance('ventas')->content()->toArray();
    }

    public function finalizarVenta()
    {
        $cartItems = Cart::instance('ventas')->content();

        DB::beginTransaction();

        try {
            $qtyDoc = Venta::count() + 1;

            $documento = 'D-' . str_pad($qtyDoc, 5, '0', STR_PAD_LEFT);

            $venta = Venta::create([
                'documento_venta' => $documento,
                'total_venta' => Cart::instance('ventas')->subtotal(),
                'id_tipo_documento' => $this->id_tipo_documento,
                'id_medio_pago' => $this->id_medio_pago,
                'id_usuario' => Auth::user()->id_usuario,
                'id_persona' => $this->id_cliente,
                'id_tipoVenta' => $this->id_tipoVenta
            ]);

            $id_venta = $venta->id_venta;

            $ventaDetalle = [];

            foreach ($cartItems as $cartItem) {
                $ventaDetalle[] = [
                    'id_venta' => $id_venta,
                    'id_producto' => $cartItem->id,
                    'cantidad_venta_detalle' => $cartItem->qty,
                    'subtotal_venta_detalle' => $cartItem->subtotal
                ];

                // Descontar Stock y validar si es oferta de venta
            }

            VentaDetalle::insert($ventaDetalle);

            // CXC
            if($this->id_tipoVenta == 2) {
                CuentaPorCobrar::create([
                    'id_venta' => $venta->id_venta,
                    'id_persona' => $venta->id_persona,
                    'dias_credito' => $this->dias_credito,
                    'fecha_vencimiento_cxc' => Carbon::now()->addDays($this->dias_credito),
                    'monto_cxc' => $venta->total_venta,
                    'saldo_pendiente_cxc' => $venta->total_venta,
                    'id_estado' => 7
                ]);
            }else { // Si no es al credito

                // Registrar movimiento de caja
                if($this->id_tipo_documento != 3) { // Valido si es diferente a una oferta de venta

                    // Obtener la caja por defecto del usuario
                    $caja = Auth::user()->caja;

                    // Buscar la apertura de caja
                    $aperturaCaja = AperturaCaja::where('id_caja', $caja->id_caja)
                    ->where('id_estado', 3)
                    ->first();

                    DetalleAperturaCaja::create([
                        'id_apertura_caja' => $aperturaCaja->id_apertura_caja,
                        'tipo_movimiento' => 'Ingreso',
                        'monto_det_apertura_caja' => $venta->total_venta,
                        'descripcion_movimiento' => 'Documento no. ' . $venta->documento_venta
                    ]);
                }
            }

            Cart::instance('ventas')->destroy();

            DB::commit();

            session()->flash('success', 'Venta No. ' . $venta->documento_venta .  ' creada correctamente.');

            return to_route('nuevoDocumento');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Hubo un error al generar la venta: ' . $th->getMessage());
        }
    }

    public function render()
    {
        // Filtro para busqueda de clientes
        $clientes = [];
        if(strlen($this->searchTermCliente) > 2) {
            $clientes = Persona::where('id_tipo_persona', 1)
            ->where(function($query) {
                $query->where('nombre_persona', 'like', '%' . $this->searchTermCliente . '%')
                      ->orWhere('codigo_persona', 'like', '%' . $this->searchTermCliente . '%')
                      ->orWhere('nit_persona', 'like', '%' . $this->searchTermCliente . '%');
            })
            ->limit(3)
            ->get();
        }else {
            $clientes = Persona::where('id_tipo_persona', 1)->limit(3)->get();
        }

        // Filtro para busqueda de productos
        $productos = [];
        if(strlen($this->searchTermProducto) > 2) {
            $productos = Producto::where('nombre_producto', 'like', '%' . $this->searchTermProducto . '%')
            ->orWhere('sku_producto', 'like', '%' . $this->searchTermProducto . '%')
            ->orWhere('cod_barra', 'like', '%' . $this->searchTermProducto . '%')
            ->limit(3)
            ->get();
        }else {
            $productos = Producto::limit(3)->get();
        }

        // Metodos de pago
        $metodosPagos = MetodoPago::all();

        // Tipo de documentos
        $tipoDocumentos = TipoDocumento::all();

        // Tipo de venta
        $tipoVentas = TipoVenta::all();

        // Subtotal
        $this->subtotal = Cart::instance('ventas')->subtotal();

        return view('livewire.venta.nuevo-documento', [
            'clientes' => $clientes,
            'productos' => $productos,
            'metodosPagos' => $metodosPagos,
            'tipoDocumentos' => $tipoDocumentos,
            'tipoVentas' => $tipoVentas,
            'cartItems' => $this->cartItems,
            'subtotal' => $this->subtotal
        ]);
    }
}
