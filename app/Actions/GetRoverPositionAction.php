<?php 

namespace App\Actions;

use App\Exceptions\RoverNotFoundException;
use App\Exceptions\RoverNotLanded;
use App\Models\MovementLog;

class GetRoverPositionAction
{
    public static function execute(int $rover_id)
    {
        $position = MovementLog::select('rover_id', 'row', 'column', 'direction')
            ->where('rover_id', $rover_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!isset($position)) {
            throw new RoverNotLanded();
        }

        return $position;
    }
}