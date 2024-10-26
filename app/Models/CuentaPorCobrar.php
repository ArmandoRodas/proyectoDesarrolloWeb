<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    use HasFactory;

    protected $table = 'tbl_cuenta_x_cobrar';
    protected $primaryKey = 'id_cxc';

    protected $fillable = [
        'id_venta',
        'id_persona',
        'dias_credito',
        'fecha_vencimiento_cxc',
        'monto_cxc',
        'saldo_pendiente_cxc',
        'id_estado'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
