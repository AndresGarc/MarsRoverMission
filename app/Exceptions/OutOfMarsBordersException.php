<?php

namespace App\Exceptions;

use Exception;

class OutOfMarsBordersException extends Exception
{
    public function __construct(int $row, int $column)
    {
        parent::__construct('Out of Mars borders on: (' . $row . ',' . $column . ')');
    }
}
