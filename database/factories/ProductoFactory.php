<?php

namespace Database\Factories;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sku_producto' => $this->faker->unique()->word(),
            'cod_barra' => $this->faker->unique()->ean13(), // Genera un código de barras EAN13
            'nombre_producto' => $this->faker->words(3, true),
            'descripcion_producto' => $this->faker->sentence(),
            'id_marca' => $this->faker->numberBetween(1, 10),
            'id_subcategoria' => $this->faker->numberBetween(1, 10),
            'vencimiento_producto' => $this->faker->date(),
            'precio_compra_producto' => $this->faker->randomFloat(2, 10, 100),
            'precio_venta_producto' => $this->faker->randomFloat(2, 20, 200),
            /*'id_estado' => $this->faker->numberBetween(1, 5),
            'id_empresa' => $this->faker->numberBetween(1, 5),
            'id_sucursal' => $this->faker->numberBetween(1, 5),*/
        ];
    }
}
