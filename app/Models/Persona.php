<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'tbl_persona';
    protected $primaryKey = 'id_persona';

    protected $fillable = [
        'codigo_persona',
        'nombre_persona',
        'direccion_persona',
        'telefono_persona',
        'correo_persona',
        'nit_persona',
        'cui_persona',
        'id_tipo_persona',
        'id_estado'
    ];

    public function tipoPersona()
    {
        return $this->belongsTo(TipoPersona::class,'id_tipo_persona');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
