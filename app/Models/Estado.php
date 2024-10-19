<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'tbl_estado';
    protected $primaryKey = 'id_estado';

    protected $fillable = [
        'nombre_estado',
        'descripcion_estado'
    ];
}
