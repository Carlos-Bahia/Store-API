<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->numberBetween(1000, 10000);
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'min_sell_price' => $price,
            'cost_price' => ($price * 0.5),
            'barcode' => $this->faker->ean8(),
            'weight' => $this->faker->numberBetween(1000, 10000),
            'height' => $this->faker->numberBetween(1000, 10000),
            'width' => $this->faker->numberBetween(1000, 10000),
            'length' => $this->faker->numberBetween(1000, 10000),
            'status' => $this->faker->randomElement(['Disponível', 'Fora de Estoque', 'Descontinuado']),
            'color' => $this->faker->randomElement(['Red', 'Yellow', 'Blue', 'Green', 'Black', 'White']),
            'size' => $this->faker->numberBetween(30,50),
            'material' => $this->faker->word(),
            'img_path' => $this->faker->imageUrl(),
        ];
    }
}
