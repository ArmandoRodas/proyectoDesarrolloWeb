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
            ['nombre_tipo_persona' => 'Cliente'],
            ['nombre_tipo_persona' => 'Proveedor'],
            ['nombre_tipo_persona' => 'Empleado'],
            ['nombre_tipo_persona' => 'Usuario'],
        ]);
    }
}
