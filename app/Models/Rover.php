<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rover extends Model
{
    /** @use HasFactory<\Database\Factories\RoverFactory> */
    use HasFactory;

    public function movement_logs() : HasMany
    {
        return $this->hasMany(MovementLog::class, 'rover_id');
    }
}
