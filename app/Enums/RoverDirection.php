<?php

namespace App\Enums;

enum RoverDirection : string
{
    case North = 'N';
    case South = 'S';
    case East = 'E';
    case West = 'W';

    /*
    public static function moveToDirection(RoverDirection $direction) : int
    {

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
    }
        */

    public static function changeDirectionToTheRight(RoverDirection $direction) : self
    {
        switch($direction) {
            case self::North: return self::East;
            case self::East: return self::South;
            case self::South: return self::West;
            case self::West: return self::North;
        }
    }

    public static function changeDirectionToTheLeft(RoverDirection $direction) : self
    {
        switch($direction) {
            case self::North: return self::West;
            case self::West: return self::South;
            case self::South: return self::East;
            case self::East: return self::North;
        }
    }
}