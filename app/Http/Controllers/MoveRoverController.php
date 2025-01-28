<?php

namespace App\Http\Controllers;

use App\Actions\MoveRoverAction;
use Illuminate\Http\Request;


class MoveRoverController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $movement = MoveRoverAction::execute($id, $request->sequence);

        return response()->json($movement, 201);
    }
}
