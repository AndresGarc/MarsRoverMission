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

        Rover::factory()->create([
            'name' => 'Rover 2'
        ]);

        Rover::factory()->create([
            'name' => 'Rover 3'
        ]);
    }

    public function test_rover_can_move_forward_looking_north_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 3,
            'column' => 0,
            'direction' => RoverDirection::North,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::North);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_south_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 3);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_east_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::East,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 3);
        $this->assertEquals($result->direction, RoverDirection::East);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_move_forward_looking_west_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 3,
            'direction' => RoverDirection::West,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFF');

        $this->assertEquals($result->commands, 'FFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::West);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_change_direction_and_keep_moving_properly_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FLFF');

        $this->assertEquals($result->commands, 'FLFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 1);
        $this->assertEquals($result->column, 2);
        $this->assertEquals($result->direction, RoverDirection::East);
        $this->assertEquals($result->details, '');
    }

    public function test_rover_can_execute_a_complex_route_without_obstacles()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 2,
            'column' => 2,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFRRFFFRL');

        $this->assertEquals($result->commands, 'FFRRFFFRL');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 1);
        $this->assertEquals($result->column, 2);
        $this->assertEquals($result->direction, RoverDirection::North);
        $this->assertEquals($result->details, '');
    }

    public function test_a_rover_encounters_an_obstacle()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 6,
            'direction' => RoverDirection::East,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 8);
        $this->assertEquals($result->direction, RoverDirection::East);
        $this->assertEquals($result->details, 'Obstacle encountered in the position: (0,9)');
    }

    public function test_a_rover_goes_out_of_borders()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::North,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::North);
        $this->assertEquals($result->details, 'Out of Mars borders on: (-1,0)');

        MovementLog::factory()->create([
            'rover_id' => 2,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 199,
            'direction' => RoverDirection::East,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 2, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 199);
        $this->assertEquals($result->direction, RoverDirection::East);
        $this->assertEquals($result->details, 'Out of Mars borders on: (0,200)');

        MovementLog::factory()->create([
            'rover_id' => 3,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 199,
            'column' => 199,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 3, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 199);
        $this->assertEquals($result->column, 199);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, 'Out of Mars borders on: (200,199)');

        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Reposition',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 199,
            'column' => 0,
            'direction' => RoverDirection::West,
            'details' => ''
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 199);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::West);
        $this->assertEquals($result->details, 'Out of Mars borders on: (199,-1)');
    }

    public function test_a_rover_cannot_move_where_a_rover_is_in_that_position()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        MovementLog::factory()->create([
            'rover_id' => 2,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 1,
            'column' => 0,
            'direction' => RoverDirection::South,
            'details' => 'First foot on Mars'
        ]);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFFF');

        $this->assertEquals($result->commands, 'FFFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Failure);
        $this->assertEquals($result->row, 0);
        $this->assertEquals($result->column, 0);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, 'Another rover in the position: (1,0)');
    
    }

    public function test_move_multiple_times_a_rover()
    {
        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 0,
            'column' => 0,
            'direction' => RoverDirection::East,
            'details' => '',
        ]);

        sleep(0.25);

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'FFFRFF');

        $this->assertEquals($result->commands, 'FFFRFF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->row, 2);
        $this->assertEquals($result->column, 3);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, '');

        $result = (new MoveRoverAction())->execute(rover_id: 1, sequence: 'RFLF');

        $this->assertEquals($result->commands, 'RFLF');
        $this->assertEquals($result->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($result->direction, RoverDirection::South);
        $this->assertEquals($result->details, '');
    }

}