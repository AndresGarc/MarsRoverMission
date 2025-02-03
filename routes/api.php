<?php

use App\Http\Controllers\GetAllRovers;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GetRoverPositionController;
use App\Http\Controllers\MoveRoverController;

Route::get('rovers', GetAllRovers::class);
Route::get('rover/{id}/position', GetRoverPositionController::class);
Route::post('rover/{id}/move', MoveRoverController::class);