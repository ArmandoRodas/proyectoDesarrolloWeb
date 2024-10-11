<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'tbl_producto';  // Especificar la tabla si es diferente de 'productos'

    protected $primaryKey = 'id_producto';  // Especificar la clave primaria si es diferente de 'id'

    public $timestamps = false;  // Si no tienes columnas 'created_at' y 'updated_at'

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
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
    ];
}
