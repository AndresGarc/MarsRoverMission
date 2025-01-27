<?php

namespace App\Http\Controllers;

use App\Actions\GetRoverPositionAction;
use Illuminate\Http\Request;
use App\Models\MovementLog;
use Exception;

class GetRoverPositionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        try {
            
            return response()
                ->json(GetRoverPositionAction::execute($id));

        } catch(Exception $e) {

            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 422);
        }
    }
}
