<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'tbl_lote';
    protected $primaryKey = 'id_lote';

    protected $fillable = [
        'numero_lote',
        'id_producto',
        'fecha_produccion',
        'fecha_vencimiento',
        'cantidad_inicial',
        'cantidad_disponible',
        'id_bodega',
        'id_estado',
        'id_sucursal',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'id_bodega');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
