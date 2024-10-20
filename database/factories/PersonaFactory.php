<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Persona;
use App\Models\TipoPersona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $counter = 1;

    public function definition(): array
    {
        // Calcular codigo
        $codigo_cliente = 'C-' . str_pad(self::$counter, 5, '0', STR_PAD_LEFT);
        self::$counter++;

        return [
            'codigo_persona' => $codigo_cliente,
            'nombre_persona' => fake()->name(),
            'direccion_persona' => fake()->address(),
            'telefono_persona' => fake()->unique()->numerify('########'),
            'correo_persona' => fake()->unique()->email(),
            'nit_persona' => fake()->unique()->numerify('#########'),
            'cui_persona' => fake()->unique()->numerify('#############'),
            'id_tipo_persona' => TipoPersona::inRandomOrder()->first()->id_tipo_persona,
            'id_estado' => Estado::inRandomOrder()->first()->id_estado
        ];
    }
}
