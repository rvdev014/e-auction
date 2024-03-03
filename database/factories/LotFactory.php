<?php

namespace Database\Factories;

use App\Models\Lot;
use App\Enums\LotType;
use App\Enums\LotStatus;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lot>
 */
class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(LotType::values()),
            'lotable_id' => Transport::query()->inRandomOrder()->first()->id,
            'lotable_type' => 'transports',
            'apply_deadline' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
            'starts_at' => $this->faker->dateTimeBetween('+1 month', '+2 month')->format('Y-m-d H:i:s'),
            'ends_at' => $this->faker->dateTimeBetween('+2 month', '+3 month')->format('Y-m-d H:i:s'),
            'starting_price' => $this->faker->numberBetween(1000, 10000),
            'deposit_amount' => $this->faker->numberBetween(10, 50),
            'step_amount' => $this->faker->numberBetween(5, 10),
            'status' => $this->faker->randomElement(LotStatus::values()),
            'cancel_reason' => $this->faker->optional()->sentence(),
        ];
    }
}
