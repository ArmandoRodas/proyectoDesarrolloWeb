<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'tbl_compra';
    protected $primaryKey = 'id_compra';

    protected $fillable = [
        'documento_compra',
        'fecha_compra',
        'monto_total_compra',
        'descripcion_compra',
        'id_metodo_pago',
        'id_tipoCompra',
        'id_usuario',
        'id_persona',
        'id_estado',
    ];
}
