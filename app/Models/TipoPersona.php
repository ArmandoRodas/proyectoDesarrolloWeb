<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    use HasFactory;

    protected $table = 'tbl_tipo_persona';
    protected $primaryKey = 'id_tipo_persona';

    protected $fillable = [
        'nombre_tipo_persona'
    ];
}