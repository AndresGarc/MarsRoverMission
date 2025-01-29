<?php

namespace Tests\Unit\Enums;

use App\Enums\RoverDirection;
use Tests\TestCase;

class RoverDirectionTest extends TestCase
{
    public function test_can_change_direction_to_the_right()
    {
        $direction = RoverDirection::changeDirectionToTheRight(RoverDirection::North);
        $this->assertEquals(RoverDirection::East, $direction);

        $direction = RoverDirection::changeDirectionToTheRight($direction);
        $this->assertEquals(RoverDirection::South, $direction);

        $direction = RoverDirection::changeDirectionToTheRight($direction);
        $this->assertEquals(RoverDirection::West, $direction);

        $direction = RoverDirection::changeDirectionToTheRight($direction);
        $this->assertEquals(RoverDirection::North, $direction);
    }

    public function test_can_change_direction_to_the_left()
    {
        $direction = RoverDirection::changeDirectionToTheLeft(RoverDirection::North);
        $this->assertEquals(RoverDirection::West, $direction);

        $direction = RoverDirection::changeDirectionToTheLeft($direction);
        $this->assertEquals(RoverDirection::South, $direction);

        $direction = RoverDirection::changeDirectionToTheLeft($direction);
        $this->assertEquals(RoverDirection::East, $direction);

        $direction = RoverDirection::changeDirectionToTheLeft($direction);
        $this->assertEquals(RoverDirection::North, $direction);
    }
}