<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $table = 'tbl_venta_detalle';
    protected $primaryKey = 'id_venta_detalle';

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad_venta_detalle',
        'subtotal_venta_detalle'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}
