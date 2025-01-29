<?php

namespace App\Exceptions;

use Exception;

class ObstacleEncounteredException extends Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct('Obstacle encountered in the position: (' . $row . ',' . $column . ')');
    }
}
