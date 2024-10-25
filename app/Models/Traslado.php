<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    use HasFactory;

    protected $table = 'tbl_traslado';

    protected $primaryKey = 'id_traslado';

    protected $fillable = [
        'fecha_traslado',
        'descripcion_traslado',
        'documento_traslado',
        'id_bodega_origen',
        'id_bodega_destino',
        'id_usuario',
        'id_estado',
        'id_empresa'
    ];

    public function bodegaOrigen()
    {
        return $this->belongsTo(Bodega::class, 'id_bodega_origen');
    }

    public function bodegaDestino()
    {
        return $this->belongsTo(Bodega::class, 'id_bodega_destino');
    }

    public function detalles()
    {
        return $this->belongsTo(TrasladoDetalle::class, 'id_traslado');
    }

    public function getFechaTrasladoAttribute()
    {
        return Carbon::parse($this->attributes['fecha_traslado'])->format('d/m/Y');
    }

}
