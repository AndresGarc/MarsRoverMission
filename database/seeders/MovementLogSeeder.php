<?php

namespace Database\Seeders;

use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Models\MovementLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovementLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MovementLog::factory()
            ->create([
                'rover_id' => 1,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 0,
                'column' => 0,
                'direction' => RoverDirection::South,
                'details' => 'First foot on Mars'
            ]);

        MovementLog::factory()
            ->create([
                'rover_id' => 2,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 4,
                'column' => 8,
                'direction' => RoverDirection::West,
                'details' => 'First foot on Mars'
            ]);

            MovementLog::factory()
            ->create([
                'rover_id' => 3,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 19,
                'column' => 178,
                'direction' => RoverDirection::North,
                'details' => 'First foot on Mars'
            ]);

            MovementLog::factory()
            ->create([
                'rover_id' => 4,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 55,
                'column' => 163,
                'direction' => RoverDirection::North,
                'details' => 'First foot on Mars'
            ]);

            MovementLog::factory()
            ->create([
                'rover_id' => 5,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 167,
                'column' => 191,
                'direction' => RoverDirection::East,
                'details' => 'First foot on Mars'
            ]);

            MovementLog::factory()
            ->create([
                'rover_id' => 6,
                'commands' => 'Landing',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 11,
                'column' => 58,
                'direction' => RoverDirection::West,
                'details' => 'First foot on Mars'
            ]);
    }
}
