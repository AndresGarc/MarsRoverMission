<?php 

namespace App\Actions;

use App\Exceptions\RoverNotFoundException;
use App\Models\MovementLog;
use Exception;
use Illuminate\Support\Facades\Log;

class GetRoverPositionAction
{
    public static function execute(int $rover_id)
    {
        $position = MovementLog::select('rover_id', 'row', 'column', 'direction')
            ->where('rover_id', $rover_id)
            ->first();

        if (!isset($position)) {
            throw new RoverNotFoundException();
        }

        return $position;
    }
}