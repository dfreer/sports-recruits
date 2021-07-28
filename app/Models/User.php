<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    public $timestamps = false;

    public static $minNumberOfPlayersPerTeam = 18;
    public static $maxNumberOfPlayersPerTeam = 22;

    public $fillable = [
        'user_type', 'first_name', 'last_name', 'ranking', 'can_play_goalie'
    ];

    public $casts = [
        'can_play_goalie' => 'boolean',
    ];

    /**
     * Players only local scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPlayers($query): Builder
    {
        return $query->where('user_type', 'player');
    }

    /**
     * Goalie local scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsGoalie($query): Builder
    {
        return $query->where('can_play_goalie', 1);
    }

    public function getIsGoalieAttribute(): bool
    {
        return (bool) $this->can_play_goalie;
    }

    public function getFullnameAttribute(): string
    {
        return Str::title($this->first_name . ' ' . $this->last_name);
    }

    public static function leagueStats()
    {
        $totalPlayers = self::ofPlayers()->count();
        $totalGoalies = self::ofPlayers()->isGoalie()->count();

        $numTeams = 2;

        // validate team size
        while (true) {
            $numPlayersPerTeam = floor($totalPlayers / $numTeams);

            // num players per team needs to be between min and max
            $valid = $numPlayersPerTeam >= self::$minNumberOfPlayersPerTeam && $numPlayersPerTeam <= self::$maxNumberOfPlayersPerTeam;

            if ($numTeams > $totalPlayers) {
                throw new Exception('Number of teams/players out of bounds!');
            }

            if (!$valid) {
                // even number of teams required...
                $numTeams += 2;
                continue;
            }

            return (object) [
                'num_teams' => $numTeams,
                'num_players_per_team' => $numPlayersPerTeam,
                'num_goalies' => $totalGoalies,
                'message' => ($totalGoalies < $numTeams) ? "There are not enough goalies ($totalGoalies) based on the number of teams ($numTeams)" : null,
            ];
        }
    }
}
