<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sports Recruits</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/app.js') }}"></script>
    </head>
    <body>
        <div class="container">
            <header>
                <img src="https://sportsrecruits.com/images/sr_otg/sr_logo_red_white.svg" alt="SportsRecruits" />
                <p>Premier League {{ date('Y') }}</p>
                @if(!isset($error))
                <nav>
                    <a class="trigger" data-target="list" href="#">List View</a> | <a class="trigger" data-target="table" href="#">Table View</a>
                </nav>
                @endif
            </header>
            @if(isset($error))
                <div class="notification is-danger">
                    {{ $error }}
                </div>
            @else
                @foreach ($teams as $team)
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $team->name }}</h3>
                            <span>
                                Team {{ $team->id }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="toggle view-list hidden">
                                {{ $team->players->map(function($player) {
                                    $name = $player->fullname;
                                    if($player->is_goalie) $name .= ' (GK)';
                                    return $name;
                                })
                                ->implode(', ') }}
                            </p>
                            <table class="toggle view-table hidden">
                                <thead>
                                    <tr>
                                        <th>Player</th>
                                        <th>Ranking</th>
                                        <th>Is goalie?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($team->players as $player)
                                        <tr>
                                            <td>{{ $player->fullname }}</td>
                                            <td>{{ $player->ranking }}</td>
                                            <td>{{ $player->is_goalie ? 'Yes' : 'No' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            Ranking sum: {{ $team->sum }}; Ranking avg: {{ $team->avg }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </body>
</html>
