<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GameplayController;

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout']);

// Game Routes
Route::middleware('auth')->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::get('/games/{game}', [GameController::class, 'show']);
    Route::post('/games/{game}/join', [GameController::class, 'join']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);

    // Gameplay Routes
    Route::get('/games/{game}/state', [GameplayController::class, 'getGameState']);
    Route::post('/games/{game}/attack', [GameplayController::class, 'attack']);
    Route::get('/games/{game}/poll', [GameplayController::class, 'pollGameState']);
    Route::get('/stats', [GameplayController::class, 'getUserStats']);
    Route::get('/games/{game}/details', [GameplayController::class, 'getGameDetails']);
});