<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrasladoDetalle extends Model
{
    use HasFactory;

    protected $table = 'tbl_detalle_traslado';
    protected $primaryKey = 'id_detalle_traslado';

    protected $fillable = [
        'id_traslado',
        'id_producto',
        'cantidad_trasladar'
    ];

    public function traslado()
    {
        return $this->belongsTo(Traslado::class, 'id_traslado');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
