<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'codigo_proveedor',
        'nombre_proveedor',
        'nit_proveedor',
        'direccion_proveedor',
        'telefono_proveedor',
        'correo_proveedor',
        'cui_proveedor',
        'estado_proveedor'
    ];
}
