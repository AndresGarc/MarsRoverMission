<?php

namespace App\Enums;

enum RoverMovementOutcome : int 
{
    case Success = 0;
    case Failure = 1;
}