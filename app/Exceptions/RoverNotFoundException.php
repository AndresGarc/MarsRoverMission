<?php

namespace App\Exceptions;

use Exception;

class RoverNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Rover not Found, please try another');
    }
}
