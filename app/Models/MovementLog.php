<?php

namespace App\Models;

use App\Enums\RoverDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\RoverMovementOutcome;

class MovementLog extends Model
{
    /** @use HasFactory<\Database\Factories\MovementLogFactory> */
    use HasFactory;

    protected $dateFormat = 'd/m/Y H:i:s.u';

    protected $fillable = [
        'rover_id',
        'commands',
        'outcome',
        'row',
        'column',
        'direction',
        'details' 
    ];

    protected $casts = [
        'outcome' => RoverMovementOutcome::class,
        'direction' => RoverDirection::class,
    ];

    public function rover() : BelongsTo
    {
        return $this->belongsTo(Rover::class);
    }
}
