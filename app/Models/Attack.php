<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attack extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'attacker_id', 'target_id', 'position', 'hit'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function attacker()
    {
        return $this->belongsTo(User::class, 'attacker_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }
}