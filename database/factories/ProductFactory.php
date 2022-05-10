<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numerify('%%.%#'),
            'code' => $this->faker->numerify('##########'),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
