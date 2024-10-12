<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedoresFactory extends Factory
{
    protected $model = \App\Models\Proveedores::class;

    protected static $counter = 1;
    protected static $activeCount = 0;

    public function definition()
    {
        // Usamos 1 para "activo" y 0 para "inactivo"
        $estado = self::$activeCount < 150 ? 1 : 0;
        if ($estado === 1) {
            self::$activeCount++;
        }

        $codigo_proveedor = 'P' . self::$counter;
        self::$counter++;

        return [
            'codigo_proveedor' => $codigo_proveedor,
            'nombre_proveedor' => $this->faker->company,
            'nit_proveedor' => $this->faker->unique()->numerify('########'),
            'direccion_proveedor' => $this->faker->address,
            'telefono_proveedor' => $this->faker->numerify('##########'),
            'correo_proveedor' => $this->faker->unique()->safeEmail,
            'cui_proveedor' => $this->faker->unique()->numerify('###########'),
            'estado_proveedor' => $estado,
        ];
    }
}
