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
    }
}
