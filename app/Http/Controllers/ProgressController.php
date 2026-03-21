<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use App\Models\UserStage;
use App\Support\StageUnlock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Samakan highest_stage_unlocked dengan stage yang sudah pernah diselesaikan.
     * Menyelesaikan stage tertinggi (mis. 2) tanpa ada stage 3 dulu tidak meng-update
     * lewat logika "next stage" saja — nilai tetap 1. Juga memperbaiki data lama.
     */
    protected function syncHighestUnlockedFromProgress(User $user): void
    {
        $maxCompletedNumber = UserStage::query()
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->join('stages', 'stages.id', '=', 'user_stages.stage_id')
            ->max('stages.stage_number');

        if ($maxCompletedNumber === null) {
            return;
        }

        $maxStageNumber = (int) Stage::query()->max('stage_number');
        $desired = min((int) $maxCompletedNumber + 1, $maxStageNumber);

        if ((int) $user->highest_stage_unlocked < $desired) {
            $user->highest_stage_unlocked = $desired;
            $user->save();
        }
    }

    public function getProgress(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->syncHighestUnlockedFromProgress($user);
        $user->refresh();

        $completedStages = UserStage::where('user_id', $user->id)
            ->where('completed', true)
            ->with('stage')
            ->get();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'total_score' => $user->total_score,
                'highest_stage_unlocked' => $user->highest_stage_unlocked,
            ],
            'completed_stages' => $completedStages,
        ]);
    }

    public function completeStage(Request $request): JsonResponse
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'score' => 'required|integer|min:0',
        ]);

        $user = $request->user();
        $stage = Stage::findOrFail($request->stage_id);

        $this->syncHighestUnlockedFromProgress($user);
        $user->refresh();

        if ((int) $stage->stage_number > (int) $user->highest_stage_unlocked) {
            return response()->json([
                'message' => 'Stage terkunci. Selesaikan stage sebelumnya dulu.',
            ], 403);
        }

        $userStage = UserStage::firstOrNew([
            'user_id' => $user->id,
            'stage_id' => $stage->id,
        ]);

        $scoreImproved = true;
        $message = 'Stage berhasil diselesaikan!';

        if ($userStage->exists && $userStage->completed) {
            // Ulangan: total skor hanya naik jika skor run ini lebih tinggi (lebih cepat = lebih banyak sisa waktu).
            if ($request->score <= $userStage->score) {
                $scoreImproved = false;
                $message = 'Skor total tidak berubah. Selesaikan lebih cepat untuk mengalahkan rekor dan menambah skor.';
            } else {
                $delta = $request->score - $userStage->score;
                $user->increment('total_score', $delta);
                $userStage->score = $request->score;
                $userStage->completed_at = now();
                $userStage->save();
                $message = 'Rekor stage diperbarui! Skor tambahan +' . $delta . '.';
            }
        } else {
            $user->increment('total_score', $request->score);
            $userStage->score = $request->score;
            $userStage->completed = true;
            $userStage->completed_at = now();
            $userStage->save();
        }

        $this->syncHighestUnlockedFromProgress($user);
        $user->refresh();

        $nextStage = Stage::where('stage_number', '>', $stage->stage_number)
            ->orderBy('stage_number')
            ->first();

        return response()->json([
            'message' => $message,
            'score_improved' => $scoreImproved,
            'user' => $user,
            'completed_stage' => $userStage->fresh(),
            'next_stage' => $nextStage,
        ]);
    }
}
