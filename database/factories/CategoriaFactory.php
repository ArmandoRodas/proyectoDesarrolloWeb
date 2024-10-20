<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_categoria' => fake()->word(),            // Genera un nombre de categoría realista (una palabra)
            'id_estado' => fake()->numberBetween(0, 1),      // Estado como 0 o 1 (activo/inactivo)
        ];
    }
}
