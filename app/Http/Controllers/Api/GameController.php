<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $games = Game::whereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['users' => function($query) {
            $query->select('users.id', 'users.name');
        }])->get();

        return response()->json($games);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $game = Game::create([
        'name' => $request->name,
        'status' => 'waiting',
    ]);

    $game->users()->attach(Auth::id(), ['remaining_ships' => 15]);

    // Retornar respuesta con código 201 y los datos del juego
    return response()->json([
        'message' => 'Juego creado exitosamente',
        'game' => [
            'id' => $game->id,
            'name' => $game->name,
            'status' => $game->status,
            'created_at' => $game->created_at,
            'updated_at' => $game->updated_at
        ]
    ], 201); // Código HTTP 201 para "Created"
}

    public function show(Game $game)
    {
        $this->authorize('view', $game);

        $game->load(['users' => function($query) {
            $query->select('users.id', 'users.name');
        }, 'attacks' => function($query) {
            $query->with(['attacker', 'target']);
        }]);

        return response()->json($game);
    }

   public function join(Game $game)
{
    $this->authorize('join', $game);
    
    $user = auth()->user();
    
    // Verifica si ya está en el juego
    if ($game->users()->where('user_id', $user->id)->exists()) {
        return response()->json(['message' => 'Ya estás en este juego'], 400);
    }

    $game->users()->attach($user->id, ['remaining_ships' => 15]);

    if ($game->isReadyToStart()) {
        $game->startGame();
    }

    return response()->json([
        'message' => 'Te has unido al juego exitosamente',
        'game' => $game->load('users')
    ]);
}

    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);
        $game->delete();
        return response()->json(null, 204);
    }
}