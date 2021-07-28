<?php

namespace App\Http\Controllers;

use Faker\Factory;
use App\Models\User;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index(Request $request)
    {
        $faker = Factory::create();

        // for ($i = 0; $i < 5000; $i++) {
        //     User::create([
        //         'user_type' => 'player',
        //         'first_name' => $faker->firstName,
        //         'last_name' => $faker->lastName,
        //         'ranking' => rand(1, 5),
        //         'can_play_goalie' => $i % 10 == 0
        //     ]);
        // }

        // make sure the stats support our league first before we calculate our teams
        $leagueStats = User::leagueStats();

        if ($msg = $leagueStats->message) {
            return view('league', ['error' => $msg]);
        }

        $goalies = User::ofPlayers()
            ->isGoalie()
            ->limit($leagueStats->num_teams)
            ->orderBy('ranking', 'desc')
            ->get();

        $players = User::ofPlayers()
            ->whereNotIn('id', $goalies->pluck('id'))
            ->orderBy('ranking', 'desc')
            ->get();

        $teams = collect([]);
        $ceil = $leagueStats->num_teams + 1;
        for ($i = 1; $i < $ceil; $i++) {
            $teams->push((object) [
                'id' => $i,
                'name' => $faker->catchPhrase,
                'players' => collect([$goalies->shift()]),
                'sum' => 0,
                'avg' => 0,
            ]);
        }

        // i know there is probably a computer science way of doing this
        // but I thought about how I would do it on the field and this was my approach
        foreach ($players as $player) {
            $lowestRankedTeam = $teams->sortBy('sum')->values()->first();
            $lowestRankedTeam->players->push($player);
            $lowestRankedTeam->sum = $lowestRankedTeam->players->sum('ranking');
            $lowestRankedTeam->avg = round($lowestRankedTeam->players->avg('ranking'), 4);
        }

        return view('league', compact('teams'));
    }
}
