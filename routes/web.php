<?php

use App\Http\Controllers\GameIslandController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.submit');

Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.submit');

Route::get('/auth/handoff', [WebAuthController::class, 'handoff'])->name('auth.handoff');

Route::get('/', function () {
    return view('landing');
});

// Link / cache lama ke map.html (file sudah dihapus) → dashboard Pilih Pulau
Route::get('/map.html', function () {
    return redirect()->route('game');
});

Route::get('/game', function () {
    return view('game');
})->name('game');

Route::get('/game/island/{island}', [GameIslandController::class, 'show'])
    ->where('island', '[a-z]+')
    ->name('game.island');

Route::get('/play', function () {
    return view('memory-game');
})->name('play');

// Bookmark / link lama ke game.html → /play
Route::redirect('/game.html', '/play', 301);
