<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source_id' => $this->faker->unique()->numberBetween(1, 1000000), 
            'latitude'  => $this->faker->latitude(10, 90), 
            'longitude' => $this->faker->longitude(-180, 180), 
        ];
    }
}
