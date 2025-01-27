<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\RoverMovementOutcome;

class MovementLog extends Model
{
    /** @use HasFactory<\Database\Factories\MovementLogFactory> */
    use HasFactory;

    protected $casts = [
        'outcome' => RoverMovementOutcome::class,
    ];

    public function rover() : BelongsTo
    {
        return $this->belongsTo(Rover::class);
    }
}
