<?php

namespace App\Http\Controllers;

use App\Models\Rover;
use Illuminate\Http\Request;

class GetAllRovers extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json(Rover::get());
    }
}
