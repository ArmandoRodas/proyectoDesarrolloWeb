<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorPagar extends Model
{
    use HasFactory;

    protected $table = 'tbl_cuenta_x_pagar';
    protected $primaryKey = 'id_cxp';

    protected $fillable = [
        'id_proveedor',
        'monto_cxp',
        'fecha_emision_cxp',
        'fecha_vencimiento_cxp',
        'id_estado',
        'id_sucursal',
        'descripcion_cxp'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
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
