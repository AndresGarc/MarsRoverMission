<?php

namespace App\Actions;

use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Models\MovementLog;

class MoveRoverAction
{
    public static function execute(int $rover_id, string $sequence)
    {
        $last_position = GetRoverPositionAction::execute($rover_id);
        

        $direction = $last_position->direction;
        $position_x = $last_position->position_x;
        $position_y = $last_position->position_y;


        // Movement algorithm
        foreach(str_split($sequence) as $move)
        {
            switch($move) {
            
                case "F":
                    // TODO: Obstacle detection
                    switch($direction) {

                        case RoverDirection::North:
                            $position_y += 1;
                            break;

                        case RoverDirection::South:
                            $position_y -= 1;
                            break;

                        case RoverDirection::East:
                            $position_x += 1;
                            break;

                        case RoverDirection::West:
                            $position_x -= 1;
                            break;
                    }
                    break;
                
                case "R":
                    $direction = RoverDirection::changeDirectionToTheRight($direction);
                    break;

                case "L":
                    $direction = RoverDirection::changeDirectionToTheLeft($direction);
                    break;
            } 
            

        }

        return MovementLog::create([
            'rover_id' => $rover_id,
            'commands' => $sequence,
            'outcome' => RoverMovementOutcome::Success,
            'position_x' => $position_x,
            'position_y' => $position_y,
            'direction' => $direction,
            'details' => ''
        ]);


    }



    
}