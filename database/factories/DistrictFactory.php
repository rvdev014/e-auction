<?php

namespace Database\Factories;

use App\Models\Region;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'region_id' => Region::query()->inRandomOrder()->first()?->id ?? Region::factory()->create()->id,
        ];
    }
}
