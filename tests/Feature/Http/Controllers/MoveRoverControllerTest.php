<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Models\MovementLog;
use App\Models\Rover;
use Illuminate\Http\Response;
use Tests\TestCase;

class MoveRoverControllerTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        Rover::factory()->create([
            'name' => 'Rover 1'
        ]);

        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 100,
            'position_y' => 100,
            'direction' => RoverDirection::North,
            'details' => 'First foot on Mars'
        ]);
    }

    public function test_send_rover_movement_actions_correct_instructions() : void
    {

        $this->json('post', 'api/rover/1/move', ['sequence' => 'FFF'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'rover_id' => 1,
                'commands' => 'FFF',
                'outcome' => RoverMovementOutcome::Success,
                'position_x' => 100,
                'position_y' => 103,
                'direction' => RoverDirection::North,
                'details' => ''
            ]);


    }

}