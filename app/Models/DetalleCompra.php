<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'tbl_compra_detalle';
    protected $primaryKey = 'id_compra_detalle';

    protected $fillable = [
        'id_compra',
        'id_lote',
        'nombre_producto_dcompra',
        'cantidad_producto_dcompra',
        'precio_unitario_producto_dcompra',
        'subtotal_dcompra'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compra');
    }
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote', 'id_lote');
    }
}
