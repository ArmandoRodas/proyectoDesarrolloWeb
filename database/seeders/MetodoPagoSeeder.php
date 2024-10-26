<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_metodo_pago')->insert([
            ['nombre_metodo_pago' => 'EFECTIVO'],
            ['nombre_metodo_pago' => 'TRANSFERENCIA'],
            ['nombre_metodo_pago' => 'CHEQUE'],
        ]);
    }
}
