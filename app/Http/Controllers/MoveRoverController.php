<?php

namespace App\Http\Controllers;

use App\Actions\MoveRoverAction;
use App\Exceptions\RoverNotLanded;
use App\Http\Requests\MoveRoverRequest;
use Illuminate\Http\Request;


class MoveRoverController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MoveRoverRequest $request, MoveRoverAction $moveRover)
    {
        try {
            $movement = $moveRover->execute($request->validated("id"), $request->validated("sequence"));

            return response()->json($movement, 201);

        } catch(RoverNotLanded $e) {

            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 404);
        }


    }
}
