<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo_cliente' => 'C' . fake()->randomNumber(1, true),  // Código de cliente C1, C2...
            'nombre_cliente' => fake()->name(),                       // Nombre de cliente realista
            'nit_cliente' => fake()->unique()->numerify('########'),  // NIT cliente como número único de 8 dígitos
            'direccion_cliente' => fake()->address(),                 // Dirección realista
        ];
    }
}
