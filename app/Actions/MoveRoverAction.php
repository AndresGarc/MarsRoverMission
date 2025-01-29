<?php

namespace App\Actions;

use App\Enums\RoverDirection;
use App\Enums\RoverMovementOutcome;
use App\Exceptions\AnotherRoverInThatPositionException;
use App\Exceptions\ObstacleEncounteredException;
use App\Exceptions\OutOfMarsBordersException;
use App\Models\MovementLog;
use App\Models\Rover;
use Exception;
use Illuminate\Support\Facades\File;

class MoveRoverAction
{
    public function execute(int $rover_id, string $sequence)
    {
        $last_position = GetRoverPositionAction::execute($rover_id);
        

        $direction = $last_position->direction;
        $row = $last_position->row;
        $column = $last_position->column;
        $map = $this->getMap('app/private/mars_map.json');


        try {
            foreach(str_split($sequence) as $move) {
                switch($move) {
                    case "F":
                        $this->obstacleDetection($rover_id, $map, $column, $row, $direction);
                        switch($direction) {

                            case RoverDirection::North:
                                $row -= 1;
                                break;

                            case RoverDirection::South:
                                $row += 1;
                                break;

                            case RoverDirection::East:
                                $column += 1;
                                break;

                            case RoverDirection::West:
                                $column -= 1;
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
        } catch (OutOfMarsBordersException | ObstacleEncounteredException | AnotherRoverInThatPositionException $e) {
            return MovementLog::create([
                'rover_id' => $rover_id,
                'commands' => $sequence,
                'outcome' => RoverMovementOutcome::Failure,
                'row' => $row,
                'column' => $column,
                'direction' => $direction,
                'details' => $e->getMessage()
            ]);
        } 

        return MovementLog::create([
            'rover_id' => $rover_id,
            'commands' => $sequence,
            'outcome' => RoverMovementOutcome::Success,
            'row' => $row,
            'column' => $column,
            'direction' => $direction,
            'details' => ''
        ]);


    }


    private function obstacleDetection(int $rover_id, mixed $map, int $column, int $row, RoverDirection $direction) : void
    {
        
        switch($direction) {

            case RoverDirection::North:
                $row -= 1;
                break;

            case RoverDirection::South:
                $row += 1;
                break;

            case RoverDirection::East:
                $column += 1;
                break;

            case RoverDirection::West:
                $column -= 1;
                break;
        }


        $other_rovers = Rover::select('id')
            ->where('id', '!=', $rover_id)
            ->pluck('id')
            ->toArray();

        
        foreach($other_rovers as $rover) {
            $last_rover_localization = MovementLog::select('row', 'column')->where('id', $rover)->first();
            if(!isset($last_rover_localization))
                continue;

            if($last_rover_localization->row == $row && $last_rover_localization->column == $column)
                throw new AnotherRoverInThatPositionException($row, $column);
        }


        if($this->isOutOfBorders($row, $column))
            throw new OutOfMarsBordersException($row, $column); 

        if($this->isAnObstacle($map, $row, $column))
            throw new ObstacleEncounteredException($row, $column); 

    }

    private function getMap(string $path) : mixed
    {
        return json_decode(File::get(storage_path($path)));
    }

    private function isOutOfBorders(int $row, int $column) : bool
    {
        return ($row > 200 || $row < 0 || $column > 200 || $column < 0 );
    }

    private function isAnObstacle(mixed $map, int $row, int $column) : bool
    {
        return $map[$row][$column] == 'X';
    }

    
}