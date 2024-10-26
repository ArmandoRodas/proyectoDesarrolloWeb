<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'tbl_venta';
    protected $primaryKey = 'id_venta';

    protected $fillable = [
        'documento_venta',
        'total_venta',
        'id_tipo_documento',
        'id_medio_pago',
        'id_usuario',
        'id_persona',
        'id_tipoVenta'
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }

    public function MetodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_medio_pago');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipoVenta()
    {
        return $this->belongsTo(tipoVenta::class, 'id_tipoVenta');
    }
}
