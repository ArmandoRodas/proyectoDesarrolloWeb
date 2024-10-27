<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'tbl_unidad_medida';
    protected $primaryKey = 'id_unidad_medida';

    protected $fillable = [
        'codigo_unidad_medida',
        'nombre_unidad_medida',
        'id_estado'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
