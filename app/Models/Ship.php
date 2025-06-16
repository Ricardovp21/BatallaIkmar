<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;

    protected $fillable = ['board_id', 'position', 'hit'];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}