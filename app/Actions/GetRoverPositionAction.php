<?php 

namespace App\Actions;

use App\Models\MovementLog;
use Exception;
use Illuminate\Support\Facades\Log;

class GetRoverPositionAction
{
    public static function execute(int $rover_id)
    {
        $position = MovementLog::select('rover_id', 'position_x', 'position_y')
            ->where('rover_id', $rover_id)
            ->first();

        if (!isset($position)) {
            Log::error('Rover with id ' . $rover_id . ' not Found');
            throw new Exception('Rover not Found, please try another');
        }

        return $position;
    }
}