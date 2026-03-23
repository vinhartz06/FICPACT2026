<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use App\Support\StageUnlock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class StageController extends Controller
{
    public function index(): JsonResponse
    {
        $stages = Stage::query()
            ->orderBy('stage_number')
            ->get();

        return response()->json($stages);
    }

    public function cards(Request $request, Stage $stage): JsonResponse
    {
        $user = $request->user('sanctum');
        if (! $user instanceof User && $request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($request->bearerToken());
            $candidate = $accessToken?->tokenable;
            $user = $candidate instanceof User ? $candidate : null;
        }

        if ($user instanceof User) {
            StageUnlock::syncFromCompletions($user);
            $user->refresh();
            if ((int) $stage->stage_number > (int) $user->highest_stage_unlocked) {
                return response()->json([
                    'message' => 'Stage terkunci. Selesaikan stage sebelumnya dulu.',
                ], 403);
            }
        }

        $topics = $stage->topics()
            ->with('cards')
            ->get();

        $cards = [];
        foreach ($topics as $topic) {
            foreach ($topic->cards as $card) {
                $cards[] = [
                    'id' => $card->id,
                    'topic_id' => $topic->id,
                    'topic_name' => $topic->name,
                    'type' => $card->type,
                    'content' => $card->content,
                ];
            }
        }

        return response()->json([
            'stage' => $stage,
            'cards' => $cards,
        ]);
    }
}

