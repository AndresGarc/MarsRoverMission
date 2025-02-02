<?php

namespace App\Exceptions;

use Exception;

class RoverNotLanded extends Exception
{
    public function __construct()
    {
        parent::__construct('Rover not landed yet, please contact command tower.');
    }
}
