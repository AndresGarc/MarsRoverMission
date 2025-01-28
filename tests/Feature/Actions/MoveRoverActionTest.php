<?php

namespace Tests\Feature\Actions;

use App\Actions\MoveRoverAction;
use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Models\MovementLog;
use App\Models\Rover;
use Tests\TestCase;

class MoveRoverActionTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        Rover::factory()->create([
            'name' => 'Rover 1'
        ]);
    }

    public function test_rover_can_move_forward_looking_north()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 100,
            'position_y' => 100,
            'direction' => RoverDirection::North,
            'details' => 'First foot on Mars'
        ]);

        $result = MoveRoverAction::execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->position_x, 100);
        $this->assertEquals($result->position_y, 103);
        $this->assertEquals($result->direction, RoverDirection::North);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_south()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 100,
            'position_y' => 100,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = MoveRoverAction::execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->position_x, 100);
        $this->assertEquals($result->position_y, 97);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_east()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 100,
            'position_y' => 100,
            'direction' => RoverDirection::East,
            'details' => 'First foot on Mars'
        ]);

        $result = MoveRoverAction::execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->position_x, 103);
        $this->assertEquals($result->position_y, 100);
        $this->assertEquals($result->direction, RoverDirection::East);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_west()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => 100,
            'position_y' => 100,
            'direction' => RoverDirection::West,
            'details' => 'First foot on Mars'
        ]);

        $result = MoveRoverAction::execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->position_x, 97);
        $this->assertEquals($result->position_y, 100);
        $this->assertEquals($result->direction, RoverDirection::West);
        $this->assertEquals($result->details, '');
    }
}