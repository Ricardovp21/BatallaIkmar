<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'games_played' => $user->games()->count(),
            'games_won' => $user->games()->where('winner_id', $user->id)->count(),
            'win_rate' => $user->winRate(),
            'ranking' => $user->ranking(),
        ]);
    }
}