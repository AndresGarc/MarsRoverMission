<?php

namespace App\Exceptions;

use Exception;

class AnotherRoverInThatPositionException extends Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct('Another rover in the position: (' . $row . ',' . $column . ')');
    }
}
