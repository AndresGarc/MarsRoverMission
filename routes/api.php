<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GetRoverPositionController;
use App\Http\Controllers\MoveRoverController;


Route::get('rover/{id}/position', GetRoverPositionController::class);
Route::post('rover/{id}/move', MoveRoverController::class);