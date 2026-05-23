<?php

namespace App\Models;

use A17\Twill\Models\Model;

class GameScore extends Model
{
    protected $fillable = [
        'published',
        'position',
        'home_team',
        'away_team',
        'home_score',
        'away_score',
        'sport',
        'game_date',
        'status',
        'venue',
        'notes',
    ];

    protected $casts = [
        'game_date'  => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
    ];

    /** Display name used in Twill breadcrumbs */
    public function getAdminEditUrlAttribute(): string
    {
        return '';
    }

    /** Human-readable status label */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'final'     => 'Final',
            'postponed' => 'Postponed',
            default     => 'Upcoming',
        };
    }

    /** True if the game has a result */
    public function getIsFinalAttribute(): bool
    {
        return $this->status === 'final';
    }
}
