<?php

namespace Tests\Feature\Actions;

use App\Actions\GetRoverPositionAction as ActionsGetRoverPositionAction;
use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Exceptions\RoverNotFoundException;
use App\Models\MovementLog;
use App\Models\Rover;
use Tests\TestCase;

class GetRoverPositionAction extends TestCase
{
    protected function setUp(): void
    {
        Rover::factory()->create([
            'name' => 'Rover 1'
        ]);

        MovementLog::factory()->create([
            'rover_id' => 1,
            'commands' => 'Landing',
            'outcome' => RoverMovementOutcome::Success,
            'row' => 3,
            'column' => 0,
            'direction' => RoverDirection::North,
            'details' => 'First foot on Mars'
        ]);
    }

    public function test_can_get_the_last_movement_of_a_rover()
    {
        $last_movement = (new ActionsGetRoverPositionAction())->execute(1);

        $this->assertEquals($last_movement->commands, 'Landing');
        $this->assertEquals($last_movement->outcome, RoverMovementOutcome::Success);
        $this->assertEquals($last_movement->row, 3);
        $this->assertEquals($last_movement->column, 0);
        $this->assertEquals($last_movement->direction, RoverDirection::North);
        $this->assertEquals($last_movement->details, 'First foot on Mars');
    }

    public function test_return_proper_exception_when_the_movement_doesnt_exist()
    {
        (new ActionsGetRoverPositionAction())->execute(5);
        $this->expectException(RoverNotFoundException::class);
    }
}