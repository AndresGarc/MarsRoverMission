<?php

use App\Http\Controllers\GetRoverPositionController;
use Illuminate\Support\Facades\Route;

Route::get('rover/{id}/position', GetRoverPositionController::class);
