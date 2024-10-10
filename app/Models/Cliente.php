<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_cliente',
        'nombre_cliente',
        'nit_cliente',
        'direccion_cliente',
        'telefono_cliente',
        'correo_cliente',
        'cui_cliente',
    ];
}
