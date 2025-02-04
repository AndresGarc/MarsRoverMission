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
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::East,
            'details' => 'First foot on Mars'
        ]);
    }

    public function test_send_rover_multiple_actions_with_correct_instructions() : void
    {

        $this->json('post', 'api/rover/1/move', ['sequence' => 'FFF'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'rover_id' => 1,
                'commands' => 'FFF',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 0,
                'column' => 3,
                'direction' => RoverDirection::East,
                'details' => 'Rover moved correctly to: (0,3), E'
            ]);


        $this->json('post', 'api/rover/1/move', ['sequence' => 'RFFFLFFFFFFFRFLF'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'rover_id' => 1,
                'commands' => 'RFFFLFFFFFFFRFLF',
                'outcome' => RoverMovementOutcome::Success,
                'row' => 4,
                'column' => 11,
                'direction' => RoverDirection::East,
                'details' => 'Rover moved correctly to: (4,11), E'
            ]);
    }

    public function test_returns_proper_information_with_with_bad_command_sequence()
    {
        $this->json('post', 'api/rover/1/move', ['sequence' => 'Landing'])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonFragment([
            "message" => "The sequence field format is invalid.",
            "errors" => [
              "sequence" => [
                0 => "The sequence field format is invalid."
              ]
            ]
        ]);
    }

    public function test_returns_proper_information_with_with_bad_id()
    {
        $this->json('post', 'api/rover/asd/move', ['sequence' => 'FFF'])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonFragment([
            "message" => "The id field must be an integer.",
            "errors" => [
              "id" => [
                0 => "The id field must be an integer."
              ]
            ]
        ]);
    }

    public function test_returns_proper_information_when_rover_doesnt_exists()
    {
        $this->json('post', 'api/rover/8/move', ['sequence' => 'FFF'])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonFragment([
            "message" => "The selected id is invalid.",
            "errors" => [
              "id" => [
                0 => "The selected id is invalid."
              ]
            ]
        ]);
    }

    public function test_returns_proper_information_with_bad_rover_id()
    {
        $this->json('post', 'api/rover/asd/move', ['sequence' => 'FFF'])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonFragment([
            "message" => "The id field must be an integer.",
            "errors" => [
              "id" => [
                0 => "The id field must be an integer."
              ]
            ]
        ]);
    }

    public function test_returns_proper_information_when_rover_not_landed_yet()
    {
        Rover::factory()->create();

        $this->json('post', 'api/rover/2/move', ['sequence' => 'FFF'])
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonFragment([
            "error" => "Rover not landed yet, please contact command tower."
        ]);
    }

}