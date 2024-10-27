<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegaProducto extends Model
{
    use HasFactory;

    protected $table = 'tbl_bodega_producto';

    protected $primaryKey = 'id_bodega_producto';

    protected $fillable = [
        'id_bodega',
        'id_producto',
        'stock_producto',
        'stock_min_producto',
        'stock_max_producto',
    ];

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'id_bodega');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
