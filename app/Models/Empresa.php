<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'tbl_empresa';
    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'nombre_empresa',
        'NIT_empresa',
        'direccion_empresa',
        'telefono_empresa',
        'email_empresa',
        'id_pais',
        'id_departamento',
        'id_municipio',
        'id_estado',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
