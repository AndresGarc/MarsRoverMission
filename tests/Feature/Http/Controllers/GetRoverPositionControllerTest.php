<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\RoverDirection;
use App\Models\MovementLog;
use App\Models\Rover;
use Illuminate\Http\Response;
use App\Enums\RoverMovementOutcome;
use Tests\TestCase;

class GetRoverPositionControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Rover::factory(3)->create();
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'FFRRFFFRL',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 0,
            'position_y' => 0,
            'direction' => RoverDirection::North,
            'details' => '',
        ]);
    }

    public function test_return_proper_information_for_an_existing_rover()
    {

        $this->json('get', '/api/rover/1/position')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'rover_id',
                'position_x',
                'position_y',
                'direction'
            ])
            ->assertJsonFragment([
                'rover_id' => 1,
                'position_x' => 0,
                'position_y' => 0,
                'direction' => RoverDirection::North,
            ]);
    }

    public function test_return_proper_error_information_when_the_rover_doesnt_exist()
    {
        $this->json('get', '/api/rover/6/position')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment([
                'error' => 'Rover not Found, please try another'
            ]);
    }

    

}