<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrasladoDetalle extends Model
{
    use HasFactory;

    protected $table = 'tbl_detalle_traslado';

    protected $fillable = [
        'id_traslado',
        'id_producto',
        'cantidad_trasladar'
    ];

    // Relación con el traslado
    public function traslado()
    {
        return $this->belongsTo(Traslado::class, 'id_traslado');
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
