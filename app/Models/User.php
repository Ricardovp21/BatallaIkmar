<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get user statistics.
     *
     * @return array
     */
    public function stats()
    {
        // Example statistics, replace with your actual logic
        return [
            'games_played' => $this->games()->count(),
            'games_won' => $this->games()->where('winner_id', $this->id)->count(),
        ];
    }

    /**
     * Relationship with games.
     */
    public function games()
    {
        return $this->hasMany(\App\Models\Game::class, 'creator_id');
    }
}