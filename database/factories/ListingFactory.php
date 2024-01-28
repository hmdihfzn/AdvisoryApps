<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'latitude' => $this->faker->randomFloat(6, -90, 90),
            'latitude' => $this->faker->randomFloat(6, -180, 180),
            'user_id' => 1
        ];
    }
}
