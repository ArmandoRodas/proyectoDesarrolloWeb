<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCompra extends Model
{
    use HasFactory;

    protected $table = 'tbl_tipo_compra';
    protected $primaryKey = 'id_tipoCompra';

    protected $fillable = [
        'nombre_tipocompra'
    ];
}
