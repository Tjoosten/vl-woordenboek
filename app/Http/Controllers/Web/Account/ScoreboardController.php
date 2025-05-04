<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Account;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use LevelUp\Experience\Facades\Leaderboard;
use LevelUp\Experience\Models\Level;
use Spatie\RouteAttributes\Attributes\Get;

final readonly class ScoreboardController
{
    #[Get(uri: '/scorebord', name: 'account.scoreboard', middleware: ['auth', 'forbid-banned-user'])]
    public function __invoke(Request $request): Renderable
    {
        return view('account.scoreboard', data: [
            'user' => $request->user(),
            'scores' => Leaderboard::generate(),
        ]);
    }
}
