<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ProductoSeeder::class);

        // Seeders
        $this->call(TipoPersonaSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(BodegaSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(TipoVentaSeeder::class);
        $this->call(MetodoPagoSeeder::class);

        // Factory
        Persona::factory(175)->create();

        // Usuario
        \App\Models\Usuario::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$SOA783nBrSAZ5CLBWCrm6OX2m62ZttqGMpFAPHwcjZ7QeWx1tFtfa',
            'id_estado' => 1 // Activo
        ]);
    }
}
