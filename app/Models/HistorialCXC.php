<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCXC extends Model
{
    use HasFactory;

    protected $table = 'tbl_historial_cxc';
    protected $primaryKey = 'id_historial_cxc';

    protected $fillable = [
        'id_cxc',
        'monto_pagado_historial_cxc',
        'referencia_pago_historial_cxc'
    ];

    public function cxc()
    {
        return $this->belongsTo(CuentaPorCobrar::class, 'id_cxc');
    }
}
