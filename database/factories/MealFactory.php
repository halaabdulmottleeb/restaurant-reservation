<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->sentence,
            'name' => $this->faker->word,
            'available_quantity' => $this->faker->numberBetween(1, 100),
            'discount' => $this->faker->numberBetween(0, 30),
        ];
    }
}
