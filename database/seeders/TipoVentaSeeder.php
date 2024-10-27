<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_tipo_venta')->insert([
            ['nombre_tipoVenta' => 'CONTADO'],
            ['nombre_tipoVenta' => 'CREDITO'],
        ]);
    }
}
