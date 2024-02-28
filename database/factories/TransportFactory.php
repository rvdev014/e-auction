<?php

namespace Database\Factories;

use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transport>
 */
class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'owner' => fake()->name,
            'car_number' => fake()->numerify,
            'year_of_issue' => fake()->year,
            'color' => fake()->colorName,
            'technical_condition' => fake()->name,
            'contract' => fake()->name,
            'address' => fake()->name,
            'additional_info' => fake()->text,
            'additional_info2' => fake()->text,
            'additional_info3' => fake()->text,
            'model' => fake()->name,
        ];
    }
}
