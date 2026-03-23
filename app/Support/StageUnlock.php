<?php

namespace App\Support;

use App\Models\Stage;
use App\Models\User;
use App\Models\UserStage;

class StageUnlock
{
    /**
     * Pemain boleh membuka stage dengan stage_number <= highest_stage_unlocked.
     * Urutan ketat: harus menyelesaikan stage 1 dulu, baru 2, dst.
     * Jika semua stage selesai: highest = nomor stage tertinggi (boleh ulang semua).
     */
    public static function syncFromCompletions(User $user): void
    {
        $maxStageNum = (int) Stage::query()->max('stage_number');
        if ($maxStageNum < 1) {
            return;
        }

        for ($n = 1; $n <= $maxStageNum; $n++) {
            $stage = Stage::query()->where('stage_number', $n)->first();
            if (! $stage) {
                break;
            }

            $completed = UserStage::query()
                ->where('user_id', $user->id)
                ->where('stage_id', $stage->id)
                ->where('completed', true)
                ->exists();

            if (! $completed) {
                self::persistIfChanged($user, $n);

                return;
            }
        }

        self::persistIfChanged($user, $maxStageNum);
    }

    private static function persistIfChanged(User $user, int $highest): void
    {
        if ((int) $user->highest_stage_unlocked === $highest) {
            return;
        }

        $user->highest_stage_unlocked = $highest;
        $user->save();
    }
}
