<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAperturaCaja extends Model
{
    use HasFactory;

    protected $table = 'tbl_detalle_apertura_caja';
    protected $primaryKey = 'id_det_apertura_caja';

    protected $fillable = [
        'id_apertura_caja',
        'tipo_movimiento',
        'monto_det_apertura_caja',
        'descripcion_movimiento'
    ];

    public function aperturaCaja()
    {
        return $this->belongsTo(AperturaCaja::class, 'id_apertura_caja');
    }
}
