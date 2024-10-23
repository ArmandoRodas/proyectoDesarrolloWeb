<?php

namespace Database\Factories;

use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estado>
 */
class EstadoFactory extends Factory
{

    protected $model = Estado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_estado' => $this->faker->word(),
            'descripcion_estado' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
