<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperturaCaja extends Model
{
    use HasFactory;

    protected $table = 'tbl_apertura_caja';
    protected $primaryKey = 'id_apertura_caja';

    protected $fillable = [
        'id_caja',
        'saldo_inicial_caja',
        'descripcion_apertura_caja',
        'id_estado'
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
