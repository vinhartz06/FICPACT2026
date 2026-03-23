<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\StageController;

Route::post('/auth', [AuthController::class, 'loginOrRegister']);

Route::get('/stages', [StageController::class, 'index']);
Route::get('/stages/{stage}/cards', [StageController::class, 'cards']);

Route::get('/leaderboard', [LeaderboardController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/progress', [ProgressController::class, 'getProgress']);
    Route::post('/progress/complete', [ProgressController::class, 'completeStage']);
});

