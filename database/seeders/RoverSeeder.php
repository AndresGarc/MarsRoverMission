<?php

namespace Database\Seeders;

use App\Models\Rover;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rover::factory()
            ->create(['name' => 'Rover 1']);

        Rover::factory()
            ->create(['name' => 'Rover 2']);

        Rover::factory()
            ->create(['name' => 'Rover 3']);
    }
}
