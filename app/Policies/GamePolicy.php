<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    /**
     * Determina si el usuario puede ver el juego
     */
    public function view(User $user, Game $game)
    {
        // Solo los jugadores del juego pueden verlo
        return $game->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determina si el usuario puede unirse al juego
     */
    public function join(User $user, Game $game)
    {
        // Puede unirse si:
        // 1. El juego está en estado 'waiting'
        // 2. El usuario no está ya en el juego
        // 3. Hay menos de 2 jugadores
        return $game->status === 'waiting' && 
               !$game->users->contains($user->id) && 
               $game->users->count() < 2;
    }

    /**
     * Determina si el usuario puede atacar en el juego
     */
    public function attack(User $user, Game $game)
    {
        // Puede atacar si:
        // 1. Es su turno
        // 2. El juego está activo
        // 3. Es participante del juego
        return $game->current_turn === $user->id &&
               $game->status === 'active' &&
               $game->users->contains($user->id);
    }

    /**
     * Determina si el usuario puede eliminar el juego
     */
    public function delete(User $user, Game $game)
    {
        // Solo el creador puede eliminar juegos en espera
        return $game->status === 'waiting' && 
               $game->users()->first()->id === $user->id;
    }
}