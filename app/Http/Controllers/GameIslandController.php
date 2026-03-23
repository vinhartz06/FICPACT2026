<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GameIslandController extends Controller
{
    /**
     * Pemetaan slug pulau → nilai kolom `stages.region` yang dipakai di DB.
     */
    private function regionsForIsland(string $island): array
    {
        $map = [
            'sumatra' => ['Aceh', 'Sumatra Utara', 'Sumatra Barat', 'Riau', 'Jambi', 'Sumatra Selatan', 'Bengkulu', 'Lampung'],
            'jawa' => ['Jawa Tengah', 'Jawa Barat', 'Jawa Timur', 'DI Yogyakarta', 'Banten', 'DKI Jakarta'],
            'bali' => ['Bali', 'NTT', 'NTB'],
            'kalimantan' => ['Kalimantan', 'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara'],
            'sulawesi' => ['Sulawesi', 'Sulawesi Utara', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Barat', 'Gorontalo'],
            'papua' => ['Papua', 'Papua Barat', 'Papua Selatan', 'Papua Pegunungan', 'Papua Tengah', 'Papua Barat Daya'],
        ];

        return $map[$island] ?? [];
    }

    private function islandTitle(string $island): string
    {
        return match ($island) {
            'sumatra' => 'Sumatra',
            'jawa' => 'Jawa',
            'bali' => 'Bali',
            'kalimantan' => 'Kalimantan',
            'sulawesi' => 'Sulawesi',
            'papua' => 'Papua',
            default => ucfirst($island),
        };
    }

    /**
     * Gambar peta pulau: cari `public/images/islands/{slug}.png|webp|jpg|svg`.
     * Ganti file PNG kamu dengan nama yang sama agar otomatis terpakai.
     */
    private function islandMapAssetUrl(string $island): ?string
    {
        foreach (['png', 'webp', 'jpg', 'jpeg', 'svg'] as $ext) {
            $rel = 'images/islands/'.$island.'.'.$ext;
            if (file_exists(public_path($rel))) {
                return asset($rel);
            }
        }

        return null;
    }

    /**
     * Koordinat pin dalam persen (0–100) relatif ke kontainer peta.
     */
    private function stagesWithPinPositions(Collection $stages): Collection
    {
        $list = $stages->values();
        $n = $list->count();

        return $list->map(function (Stage $stage, int $i) use ($n) {
            $x = $stage->map_pin_x !== null ? (float) $stage->map_pin_x : null;
            $y = $stage->map_pin_y !== null ? (float) $stage->map_pin_y : null;

            if ($x === null || $y === null) {
                $t = $n > 1 ? $i / ($n - 1) : 0.5;
                $x = round(22 + $t * 56, 2);
                $y = round(38 + sin($t * M_PI) * 14, 2);
            }

            return [
                'stage' => $stage,
                'x' => (float) $x,
                'y' => (float) $y,
            ];
        });
    }

    public function show(Request $request, string $island): View
    {
        $island = strtolower($island);
        $regions = $this->regionsForIsland($island);

        if ($regions === []) {
            abort(404);
        }

        $stages = Stage::query()
            ->whereIn('region', $regions)
            ->orderBy('stage_number')
            ->get();

        return view('island-stages', [
            'islandSlug' => $island,
            'islandTitle' => $this->islandTitle($island),
            'stages' => $stages,
            'islandMapUrl' => $this->islandMapAssetUrl($island),
            'stagesWithPins' => $this->stagesWithPinPositions($stages),
        ]);
    }
}
