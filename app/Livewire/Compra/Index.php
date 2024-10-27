<?php

namespace App\Livewire\Compra;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\CuentaPorPagar;
use App\Models\TipoDocumento;
use App\Models\TipoCompra;
use App\Models\MetodoPago;
use App\Models\Bodega;
use App\Models\BodegaProducto;
use Carbon\Carbon;

class Index extends Component
{
    //detalles
    public $descripcion_compra;
    public $id_tipo_documento;
    public $id_metodo_pago;
    public $id_tipoCompra;
    public $dias_credito;
    public $referencia;
    public $id_bodega;
    //carrito
    public $cartItems = [];
    public $subtotal = 0;
    //proveedor
    public $codigo_proveedor;
    public $id_proveedor;
    //busqueda
    public $searchTermProveedor = '';
    public $selectedProveedor = null;
    public $showDropdownProveedor = false;
    //Producto
    public $searchTermProducto = '';
    public $selectedProducto = null;
    public $showDropdownProducto = false;
//===================================================================================================================================================
    public function mount()
    {
        $this->cartItems = Cart::instance('compras')->content()->toArray();
    }
//===================================================================================================================================================
    public function toggleDropdownProveedor()
    {
        $this->showDropdownProveedor = !$this->showDropdownProveedor;
    }
//===================================================================================================================================================
    public function selectProveedor($ProveedorId)
    {
        $this->selectedProveedor = Persona::find($ProveedorId);
        $this->searchTermProveedor = $this->selectedProveedor->nombre_persona;
        $this->codigo_proveedor = $this->selectedProveedor->codigo_persona;
        $this->id_proveedor = $this->selectedProveedor->id_persona;
        $this->showDropdownProveedor = false;
    }
//===================================================================================================================================================
    public function toggleDropdownProducto()
    {
        $this->showDropdownProducto = !$this->showDropdownProducto;
    }
//===================================================================================================================================================
    public function selectProducto($productoId)
    {
        $this->selectedProducto = Producto::find($productoId);
        $this->searchTermProducto = '';
        $this->showDropdownProducto = false;
        $this->agregarAlCarrito($productoId);
    }
//===================================================================================================================================================
    public function agregarAlCarrito($productoId)
    {
        $producto = Producto::find($productoId);
        Cart::instance('compras')->add([
            'id' => $productoId,
            'name' => $producto->nombre_producto,
            'qty' => 1,
            'price' => $producto->precio_compra_producto,
            'options' => [
                'sku' => $producto->sku_producto,
            ]
        ]);
        $this->cartItems = Cart::instance('compras')->content()->toArray();
    }
//===================================================================================================================================================
    public function actualizarQtyProducto($rowId, $cantidad_compra_detalle)
    {
        if (is_numeric($cantidad_compra_detalle) && $cantidad_compra_detalle > 0) {
            Cart::instance('compras')->update($rowId, $cantidad_compra_detalle);
        }
        $this->cartItems = Cart::instance('compras')->content()->toArray();
    }
//===================================================================================================================================================
    public function eliminarProducto($rowId)
    {
        Cart::instance('compras')->remove($rowId);
        $this->cartItems = Cart::instance('compras')->content()->toArray();
    }
//===================================================================================================================================================
    public function finalizarCompra()
    {
        $cartItems = $this->cartItems;
        DB::beginTransaction();
        try {
            $qtyDoc = Compra::count() + 1;
            $documento = 'OC-' . str_pad($qtyDoc, 5, '0', STR_PAD_LEFT);
            $compra = Compra::create([
                'documento_compra' => $documento,
                'fecha_compra' => now(),
                'monto_total_compra' => Cart::instance('compras')->subtotal(),
                'descripcion_compra' => $this->descripcion_compra,
                'referencia' => $this->referencia,
                'id_metodo_pago' => $this->id_metodo_pago,
                'id_tipoCompra' => $this->id_tipoCompra,
                'id_usuario' => Auth::user()->id_usuario,
                'id_sucursal' => $this->id_bodega,
            ]);
            foreach ($cartItems as $item) {
                DetalleCompra::create([
                    'id_compra' => $compra->id_compra,
                    'nombre_producto_dcompra' => $item['name'],
                    'cantidad_producto_dcompra' => $item['qty'],
                    'precio_unitario_producto_dcompra' => $item['price'],
                    'subtotal_dcompra' => $item['qty'] * $item['price'],
                ]);
                $bodegaProducto = BodegaProducto::where('id_bodega', $this->id_bodega)
                    ->where('id_producto', $item['id'])
                    ->first();
                if ($bodegaProducto) {
                    $bodegaProducto->stock_producto += $item['qty'];
                    $bodegaProducto->save();
                } else {
                    BodegaProducto::create([
                        'id_bodega' => $this->id_bodega,
                        'id_producto' => $item['id'],
                        'stock_producto' => $item['qty'],
                        'stock_min_producto' => $item['qty'] - 2,
                        'stock_max_producto' => $item['qty'] + 2,
                    ]);
                }
            }
            if ($this->id_tipoCompra == 2) {
                CuentaPorPagar::create([
                    'id_cliente' => $this->id_proveedor,
                    'monto_cxp' => Cart::instance('compras')->subtotal(),
                    'fecha_emision_cxp' => now(),
                    'fecha_vencimiento_cxp' => Carbon::now()->addDays($this->dias_credito),
                    'id_estado' => 1,
                    'descripcion_cxp' => $this->descripcion_compra,
                ]);
            }
            DB::commit();
            Cart::instance('compras')->destroy();
            session()->flash('success', 'Compra No. ' . $compra->documento_compra . ' creada correctamente.');
            return redirect()->route('compra.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Hubo un error al generar la compra: ' . $th->getMessage());
            return back();
        }
    }
//===================================================================================================================================================
    public function render()
    {
        $proveedores = [];
        if(strlen($this->searchTermProveedor) > 2) {
            $proveedores = Persona::where('id_tipo_persona', 2)
            ->where(function($query) {
                $query->where('nombre_persona', 'like', '%' . $this->searchTermProveedor . '%')
                    ->orWhere('codigo_persona', 'like', '%' . $this->searchTermProveedor . '%')
                    ->orWhere('nit_persona', 'like', '%' . $this->searchTermProveedor . '%');
            })->limit(3)->get();
        }else {
            $proveedores = Persona::where('id_tipo_persona', 2)->limit(3)->get();
        }

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

        $metodosPagos = MetodoPago::all();

        $tipoDocumentos = TipoDocumento::all();

        $tipoCompras = TipoCompra::all();

        $bodegas = Bodega::all();

        $this->subtotal = Cart::instance('compras')->subtotal();

        return view('livewire.compra.index', [
            'proveedores' => $proveedores,
            'productos' => $productos,
            'metodosPagos' => $metodosPagos,
            'tipoDocumentos' => $tipoDocumentos,
            'tipoCompras' => $tipoCompras,
            'cartItems' => $this->cartItems,
            'subtotal' => $this->subtotal,
            'bodegas' => $bodegas
        ]);
    }
}
