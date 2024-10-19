<?php

namespace App\Providers;

use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Support\ServiceProvider;

class EmpresaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $empresa = Empresa::first();

        config([
            'id_empresa' => $empresa->id_empresa ?? null,
            'nombre_empresa' => $empresa->nombre_empresa ?? null,
            'NIT_empresa' => $empresa->NIT_empresa ?? null,
            'direccion_empresa' => $empresa->direccion_empresa ?? null,
            'telefono_empresa' => $empresa->telefono_empresa ?? null,
            'email_empresa' => $empresa->email_empresa ?? null,
            
            'id_pais' => $empresa->id_pais ?? null,
            'id_departamento' => $empresa->id_departamento ?? null,
            'id_municipio' => $empresa->id_municipio ?? null,
            'id_estado' => $empresa->id_estado ?? null,
            
            'pais_empresa' => $empresa->pais->nombre_pais ?? null,
            'departamento_empresa' => $empresa->departamento->nombre_departamento ?? null,
            'municipio_empresa' => $empresa->municipio->nombre_municipio ?? null,
            'estado_empresa' => $empresa->estado->nombre_estado ?? null,

            'paises' => Pais::where('id_pais', '!=', $empresa->id_pais ?? null)->get() ?? null,
            'departamentos' => Departamento::where('id_departamento', '!=', $empresa->id_departamento ?? null)->get() ?? null,
            'municipios' => Municipio::where('id_municipio', '!=', $empresa->id_municipio ?? null)->get() ?? null,
            'estados' => Estado::where('id_estado', '!=', $empresa->id_estado ?? null)->get() ?? null
        ]);
    }
}
