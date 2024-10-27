<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'tbl_metodo_pago';
    protected $primaryKey = 'id_metodo_pago';

    protected $fillable = [
        'nombre_metodo_pago',
        'descripcion_metodo_pago'
    ];
}
