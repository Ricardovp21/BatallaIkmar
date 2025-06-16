<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'current_turn', 'winner_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_users')->withPivot('remaining_ships');
    }

    public function attacks()
    {
        return $this->hasMany(Attack::class);
    }

    public function boards()
    {
        return $this->hasManyThrough(Board::class, GameUser::class);
    }

    public function isReadyToStart()
    {
        return $this->users()->count() === 2;
    }

    public function startGame()
    {
        if ($this->isReadyToStart()) {
            $this->update([
                'status' => 'active',
                'current_turn' => $this->users()->first()->id
            ]);
            $this->initializeBoards();
            return true;
        }
        return false;
    }

    protected function initializeBoards()
    {
        foreach ($this->users as $user) {
            $board = Board::create(['game_user_id' => $user->pivot->id]);
            $this->generateShips($board);
        }
    }

    protected function generateShips(Board $board)
    {
        $ships = [];
        $positions = [];

        while (count($positions) < 15) {
            $row = chr(rand(97, 104)); // a-h
            $col = rand(1, 8);
            $position = $row . $col;

            if (!in_array($position, $positions)) {
                $positions[] = $position;
                $ships[] = [
                    'board_id' => $board->id,
                    'position' => $position,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        Ship::insert($ships);
    }
}