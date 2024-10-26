<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_tipo_documento')->insert([
            ['nombre_tipoDocumento' => 'RECIBO'],
            ['nombre_tipoDocumento' => 'FACTURA'],
            ['nombre_tipoDocumento' => 'OFERTA DE VENTA'],
        ]);
    }
}
