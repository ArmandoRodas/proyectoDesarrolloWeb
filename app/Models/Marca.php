<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'tbl_marca';
    protected $primaryKey = 'id_marca';

    protected $fillable = [
        'nombre_marca',
        'id_estado'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
