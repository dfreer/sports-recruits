<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\User;

class PlayersIntegrityTest extends TestCase
{
    /**
     * Check there are players that have can_play_goalie set as 1
     * 
     * @return void
     */
    public function testGoaliePlayersExist()
    {
        $result = User::ofPlayers()
            ->isGoalie()
            ->count();
        $this->assertTrue($result >= 1);
    }

    /*
     * Calculate how many teams can be made so that there is 
     * an even number of teams and they each have between 18-22 players.
     * Then check that there are at least as many players who can 
     * play goalie as there are teams
     * 
     * @return void
    */
    public function testAtLeastOneGoaliePlayerPerTeam()
    {
        $leagueStats = User::leagueStats();
        $min = User::$minNumberOfPlayersPerTeam;
        $max = User::$maxNumberOfPlayersPerTeam;

        $numPlayersPerTeam = $leagueStats->num_players_per_team;
        $numGoalies = $leagueStats->num_goalies;
        $numTeams = $leagueStats->num_teams;

        $this->assertTrue($numPlayersPerTeam >= $min && $numPlayersPerTeam <= $max, "Number of players per team ($numPlayersPerTeam) not between ($min, $max)");
        $this->assertTrue($numGoalies > $numTeams, $leagueStats->message ?? '');
    }
}
