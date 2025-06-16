<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GameplayController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas de juegos
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::get('/games/{game}', [GameController::class, 'show']);
    Route::post('/games/{game}/join', [GameController::class, 'join']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    
    // Rutas de gameplay
    Route::get('/games/{game}/state', [GameplayController::class, 'getGameState']);
    Route::post('/games/{game}/attack', [GameplayController::class, 'attack']);
    Route::get('/games/{game}/poll', [GameplayController::class, 'pollGameState']);
    Route::get('/stats', [GameplayController::class, 'getUserStats']);
    Route::get('/games/{game}/details', [GameplayController::class, 'getGameDetails']);
});