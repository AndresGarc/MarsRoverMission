<?php

namespace App\Http\Controllers;

use App\Actions\GetRoverPositionAction;
use App\Exceptions\RoverNotLanded;
use App\Http\Requests\GetRoverPositionRequest;

class GetRoverPositionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetRoverPositionRequest $request)
    {
        try {
            return response()
                ->json(GetRoverPositionAction::execute($request->validated("id")));

        } catch(RoverNotLanded $e) {

            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 404);
        }
    }
}
