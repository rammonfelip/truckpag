<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        return [
            'product_name' => $faker->word,
            'brands' => $faker->word,
            'categories' => $faker->word,
            'code' => $faker->unique()->numberBetween(100000, 999999),
            'status' => 'published',
        ];
    }
}
