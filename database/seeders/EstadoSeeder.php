<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_estado')->insert([
            ['nombre_estado' => 'Activo'],
            ['nombre_estado' => 'Inactivo'],
            ['nombre_estado' => 'Abierto'],
            ['nombre_estado' => 'Cerrado'],
            ['nombre_estado' => 'Cuenta pagada'],
            ['nombre_estado' => 'Cuenta abonada'],
            ['nombre_estado' => 'Pendiente'],
        ]);
    }
}
