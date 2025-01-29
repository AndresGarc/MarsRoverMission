<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RoverMovementOutcome;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovementLog>
 */
class MovementLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rover_id' => $this->faker->numberBetween(0,10),
            'commands' => 'FFRRFFFRL',
            'outcome' => $this->faker->randomElement(RoverMovementOutcome::cases()),
            'row' => $this->faker->numberBetween(0,200),
            'column' => $this->faker->numberBetween(0,200),
            'details' => $this->faker->text(150)
        ];
    }
}
