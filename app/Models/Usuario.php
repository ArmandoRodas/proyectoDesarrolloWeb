<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'tbl_usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_estado',
        'direccion_usuario',
        'fecha_actualizacion_usuario',
        'telefono_usuario',
        'id_rol',
        'id_empresa',
        'id_sucursal',
        'id_caja'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return 'email';
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
    
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }
}
