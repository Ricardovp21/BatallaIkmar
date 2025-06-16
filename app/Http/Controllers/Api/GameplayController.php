<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attack;
use App\Models\Game;
use App\Models\Ship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameplayController extends Controller
{
    public function getGameState(Game $game)
    {
        $this->authorize('view', $game);

        $user = Auth::user();
        $opponent = $game->users()->where('user_id', '!=', $user->id)->first();

        $userBoard = $game->boards()
            ->whereHas('gameUser', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['ships'])
            ->first();

        $attacks = $game->attacks()
            ->where(function($query) use ($user) {
                $query->where('attacker_id', $user->id)
                      ->orWhere('target_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'game' => $game,
            'user_board' => $userBoard,
            'opponent' => $opponent,
            'attacks' => $attacks,
            'is_my_turn' => $game->current_turn === $user->id,
        ]);
    }

    public function attack(Game $game, Request $request)
    {
        $this->authorize('view', $game);

        $request->validate([
            'position' => 'required|regex:/^[a-h][1-8]$/i',
        ]);

        $user = Auth::user();
        $opponent = $game->users()->where('user_id', '!=', $user->id)->first();

        if ($game->current_turn !== $user->id) {
            return response()->json(['message' => 'No es tu turno'], 400);
        }

        // Verificar si la posición ya fue atacada
        $existingAttack = $game->attacks()
            ->where('attacker_id', $user->id)
            ->where('position', strtolower($request->position))
            ->exists();

        if ($existingAttack) {
            return response()->json(['message' => 'Ya has atacado esta posición'], 400);
        }

        // Buscar si hay un barco en esa posición
        $ship = Ship::whereHas('board.gameUser', function($query) use ($opponent, $game) {
                $query->where('user_id', $opponent->id)
                      ->where('game_id', $game->id);
            })
            ->where('position', strtolower($request->position))
            ->first();

        $hit = !is_null($ship);

        // Registrar el ataque
        $attack = Attack::create([
            'game_id' => $game->id,
            'attacker_id' => $user->id,
            'target_id' => $opponent->id,
            'position' => strtolower($request->position),
            'hit' => $hit,
        ]);

        // Actualizar el barco si fue golpeado
        if ($hit) {
            $ship->update(['hit' => true]);
            
            // Actualizar barcos restantes
            $remainingShips = $opponent->pivot->remaining_ships - 1;
            $game->users()->updateExistingPivot($opponent->id, ['remaining_ships' => $remainingShips]);

            // Verificar si el juego terminó
            if ($remainingShips === 0) {
                $game->update([
                    'status' => 'finished',
                    'winner_id' => $user->id,
                    'current_turn' => null,
                ]);
                
                return response()->json([
                    'message' => '¡Has ganado el juego!',
                    'attack' => $attack,
                    'game_over' => true,
                    'winner' => $user,
                ]);
            }
        }

        // Cambiar el turno
        $game->update(['current_turn' => $opponent->id]);

        return response()->json([
            'message' => $hit ? '¡Impacto!' : 'Agua',
            'attack' => $attack,
            'game_over' => false,
        ]);
    }

    public function pollGameState(Game $game)
    {
        $this->authorize('view', $game);

        $user = Auth::user();

        $state = $this->getGameState($game)->original;

        return response()->json($state);
    }

    public function getUserStats()
    {
        $user = Auth::user();

        $totalGames = Game::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'finished');
        })->count();

        $wins = Game::where('winner_id', $user->id)
            ->where('status', 'finished')
            ->count();

        $losses = $totalGames - $wins;

        $recentGames = Game::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'finished');
        })
        ->orderBy('updated_at', 'desc')
        ->take(5)
        ->get();

        return response()->json([
            'total_games' => $totalGames,
            'wins' => $wins,
            'losses' => $losses,
            'win_rate' => $totalGames > 0 ? round(($wins / $totalGames) * 100, 2) : 0,
            'recent_games' => $recentGames,
        ]);
    }

    public function getGameDetails(Game $game)
    {
        $this->authorize('view', $game);

        $user = Auth::user();
        $opponent = $game->users()->where('user_id', '!=', $user->id)->first();

        $userAttacks = $game->attacks()
            ->where('attacker_id', $user->id)
            ->orderBy('created_at')
            ->get();

        $opponentAttacks = $game->attacks()
            ->where('attacker_id', $opponent->id)
            ->orderBy('created_at')
            ->get();

        $userShips = $game->boards()
            ->whereHas('gameUser', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['ships'])
            ->first()
            ->ships;

        $opponentShips = $game->boards()
            ->whereHas('gameUser', function($query) use ($opponent) {
                $query->where('user_id', $opponent->id);
            })
            ->with(['ships'])
            ->first()
            ->ships;

        return response()->json([
            'user_attacks' => $userAttacks,
            'opponent_attacks' => $opponentAttacks,
            'user_ships' => $userShips,
            'opponent_ships' => $opponentShips,
        ]);
    }
}