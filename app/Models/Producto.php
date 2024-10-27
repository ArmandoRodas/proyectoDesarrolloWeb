<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'tbl_producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
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
        'id_sucursal'
    ];

    public function bodegaProducto()
    {
        return $this->hasMany(BodegaProducto::class, 'id_producto', 'id_producto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
