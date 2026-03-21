<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    /**
     * Daftar pemain teratas berdasarkan total skor (bisa diakses tamu).
     */
    public function index(): JsonResponse
    {
        $rows = User::query()
            ->orderByDesc('total_score')
            ->orderBy('id')
            ->limit(50)
            ->get(['id', 'name', 'total_score', 'highest_stage_unlocked']);

        return response()->json([
            'leaderboard' => $rows->map(function (User $u, int $i) {
                return [
                    'rank' => $i + 1,
                    'name' => $u->name,
                    'total_score' => $u->total_score,
                    'highest_stage_unlocked' => $u->highest_stage_unlocked,
                ];
            }),
        ]);
    }
}
