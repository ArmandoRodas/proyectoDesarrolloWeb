<?php

namespace App\Livewire\Venta;

use App\Models\Bodega;
use App\Models\MetodoPago;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\TipoDocumento;
use App\Models\TipoVenta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class NuevoDocumento extends Component
{
    public $id_tipo_documento;
    public $id_tipoVenta;

    // Carrito de ventas
    public $cartItems = [];
    public $subtotal = 0;

    public function mount()
    {
        $this->cartItems = Cart::instance('ventas')->content()->toArray();
    }

    // Cliente
    public $codigo_cliente;

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
