<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_tipo_persona')->insert([
            [
                'nombre_tipo_persona' => 'Cliente',
                'serie_persona' => 'C',
                'secuencia_persona' => 0
            ],
            [
                'nombre_tipo_persona' => 'Proveedor',
                'serie_persona' => 'P',
                'secuencia_persona' => 0
            ],
            [
                'nombre_tipo_persona' => 'Empleado',
                'serie_persona' => 'E',
                'secuencia_persona' => 0
            ],
            [
                'nombre_tipo_persona' => 'Usuario',
                'serie_persona' => 'U',
                'secuencia_persona' => 0
            ],
        ]);
    }
}
