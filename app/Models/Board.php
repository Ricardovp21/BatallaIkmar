<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    public function gameUser()
    {
        return $this->belongsTo(GameUser::class);
    }

    public function ships()
    {
        return $this->hasMany(Ship::class);
    }

    public function getGridAttribute()
    {
        $grid = [];
        $letters = range('a', 'h');
        
        foreach ($letters as $letter) {
            for ($i = 1; $i <= 8; $i++) {
                $position = $letter . $i;
                $ship = $this->ships->where('position', $position)->first();
                
                $grid[$letter][$i] = [
                    'position' => $position,
                    'has_ship' => !is_null($ship),
                    'hit' => $ship ? $ship->hit : false,
                ];
            }
        }
        
        return $grid;
    }
}