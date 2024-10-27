<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'tbl_caja';
    protected $primaryKey = 'id_caja';

    protected $fillable = [
        'nombre_caja',
        'id_sucursal',
        'descripcion_caja',
        'id_estado',
        'id_empresa'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function aperturas()
    {
        return $this->hasMany(AperturaCaja::class, 'id_caja');
    }

    // public function usuarios()
    // {
    //     return $this->hasMany(User::class, 'id_caja');
    // }
}
