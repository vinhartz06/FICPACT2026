<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Stage;
use App\Models\Topic;
use Illuminate\Database\Seeder;

/**
 * Semua stage konten (saat ini Jawa Tengah 1–5).
 * Pin map: persen relatif ke gambar pulau (jawa.png).
 */
class StageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->stageDefinitions() as $def) {
            $trilogies = $def['trilogies'];
            unset($def['trilogies']);
            $def['is_boss_stage'] = false;

            $stage = Stage::updateOrCreate(
                ['stage_number' => $def['stage_number']],
                $def
            );

            $this->seedTrilogiesForStage($stage, $trilogies);
        }
    }

    /**
     * @param  array<string, list<array{type: string, content: string}>>  $trilogies
     */
    private function seedTrilogiesForStage(Stage $stage, array $trilogies): void
    {
        foreach ($trilogies as $topicName => $cards) {
            $topic = Topic::firstOrCreate(
                ['stage_id' => $stage->id, 'name' => $topicName]
            );

            foreach ($cards as $card) {
                Card::firstOrCreate(
                    [
                        'topic_id' => $topic->id,
                        'type' => $card['type'],
                        'content' => $card['content'],
                    ]
                );
            }
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function stageDefinitions(): array
    {
        return [
            [
                'stage_number' => 1,
                'name' => 'Stage 1 - Semarang',
                'city_name' => 'Semarang',
                'region' => 'Jawa Tengah',
                'map_pin_x' => 50.5,
                'map_pin_y' => 46,
                'trilogies' => [
                    'Landmark & Sejarah (Lawang Sewu)' => [
                        ['type' => 'image', 'content' => 'lawang-sewu.jpg'],
                        ['type' => 'text', 'content' => 'Lawang Sewu'],
                        ['type' => 'text', 'content' => 'Gedung Seribu Pintu'],
                    ],
                    'Monumen Pahlawan (Tugu Muda)' => [
                        ['type' => 'image', 'content' => 'tugu-muda.jpg'],
                        ['type' => 'text', 'content' => 'Tugu Muda'],
                        ['type' => 'text', 'content' => 'Pertempuran Lima Hari'],
                    ],
                    'Akulturasi Budaya (Sam Poo Kong)' => [
                        ['type' => 'image', 'content' => 'sam-poo-kong.jpg'],
                        ['type' => 'text', 'content' => 'Kelenteng Sam Poo Kong'],
                        ['type' => 'text', 'content' => 'Laksamana Cheng Ho'],
                    ],
                    'Tata Kota Bersejarah (Kota Lama)' => [
                        ['type' => 'image', 'content' => 'kota-lama.jpg'],
                        ['type' => 'text', 'content' => 'Kota Lama Semarang'],
                        ['type' => 'text', 'content' => 'Little Netherland'],
                    ],
                    'Kuliner Legendaris (Lumpia)' => [
                        ['type' => 'image', 'content' => 'lumpia.jpg'],
                        ['type' => 'text', 'content' => 'Lumpia Semarang'],
                        ['type' => 'text', 'content' => 'Isian Rebung & Udang'],
                    ],
                    'Oleh-Oleh Khas (Bandeng Presto)' => [
                        ['type' => 'image', 'content' => 'bandeng-presto.jpg'],
                        ['type' => 'text', 'content' => 'Bandeng Presto'],
                        ['type' => 'text', 'content' => 'Ikan Duri Lunak'],
                    ],
                ],
            ],
            [
                'stage_number' => 2,
                'name' => 'Stage 2 - Solo',
                'city_name' => 'Solo',
                'region' => 'Jawa Tengah',
                'map_pin_x' => 51.5,
                'map_pin_y' => 51,
                'trilogies' => [
                    'Trilogi Pusat Kebudayaan (Keraton Surakarta)' => [
                        ['type' => 'image', 'content' => 'solo-keraton-surakarta.jpg'],
                        ['type' => 'text', 'content' => 'Keraton Kasunanan'],
                        ['type' => 'text', 'content' => 'Pusat Kebudayaan Jawa'],
                    ],
                    'Trilogi Pusat Ekonomi Bersejarah (Pasar Klewer)' => [
                        ['type' => 'image', 'content' => 'solo-pasar-klewer.jpg'],
                        ['type' => 'text', 'content' => 'Pasar Klewer'],
                        ['type' => 'text', 'content' => 'Pusat Grosir Sandang'],
                    ],
                    'Trilogi Kesenian Tradisional (Wayang Orang Sriwedari)' => [
                        ['type' => 'image', 'content' => 'solo-wayang-orang-sriwedari.jpg'],
                        ['type' => 'text', 'content' => 'Taman Sriwedari'],
                        ['type' => 'text', 'content' => 'Wayang Orang'],
                    ],
                    'Trilogi Kuliner Manis Legendaris (Serabi Notosuman)' => [
                        ['type' => 'image', 'content' => 'solo-serabi-notosuman.jpg'],
                        ['type' => 'text', 'content' => 'Serabi Notosuman'],
                        ['type' => 'text', 'content' => 'Jajanan Manis Legendaris'],
                    ],
                    'Trilogi Sejarah Kolonial (Benteng Vastenburg)' => [
                        ['type' => 'image', 'content' => 'solo-benteng-vastenburg.jpg'],
                        ['type' => 'text', 'content' => 'Benteng Vastenburg'],
                        ['type' => 'text', 'content' => 'Peninggalan Kolonial Belanda'],
                    ],
                    'Trilogi Kampung Kreatif (Kampung Batik Laweyan)' => [
                        ['type' => 'image', 'content' => 'solo-kampung-batik-laweyan.jpg'],
                        ['type' => 'text', 'content' => 'Kampung Batik Laweyan'],
                        ['type' => 'text', 'content' => 'Jejak Saudagar Batik'],
                    ],
                    'Trilogi Easter Egg (Tembok Ratapan)' => [
                        ['type' => 'image', 'content' => 'solo-ratapan.jpg'],
                        ['type' => 'text', 'content' => 'Fenomena viral GMaps'],
                        ['type' => 'text', 'content' => 'Meratap di gerbang rumah'],
                    ],
                ],
            ],
            [
                'stage_number' => 3,
                'name' => 'Stage 3 - Magelang',
                'city_name' => 'Magelang',
                'region' => 'Jawa Tengah',
                'map_pin_x' => 47,
                'map_pin_y' => 56,
                'trilogies' => [
                    'Trilogi Keajaiban Dunia (Borobudur)' => [
                        ['type' => 'image', 'content' => 'magelang-borobudur.jpg'],
                        ['type' => 'text', 'content' => 'Candi Borobudur'],
                        ['type' => 'text', 'content' => 'Wangsa Syailendra'],
                    ],
                    'Trilogi Pemandangan Alam (Gunung Tidar)' => [
                        ['type' => 'image', 'content' => 'magelang-gunung-tidar.jpg'],
                        ['type' => 'text', 'content' => 'Gunung Tidar'],
                        ['type' => 'text', 'content' => 'Paku Tanah Jawa'],
                    ],
                    'Trilogi Sejarah Pahlawan (Perang Jawa)' => [
                        ['type' => 'image', 'content' => 'magelang-diponegoro.jpg'],
                        ['type' => 'text', 'content' => 'Pangeran Diponegoro'],
                        ['type' => 'text', 'content' => 'Taktik Gerilya'],
                    ],
                    'Trilogi Candi Pendamping (Candi Mendut)' => [
                        ['type' => 'image', 'content' => 'magelang-candi-mendut.jpg'],
                        ['type' => 'text', 'content' => 'Candi Mendut'],
                        ['type' => 'text', 'content' => 'Arca Buddha Raksasa'],
                    ],
                    'Trilogi Kuliner Berkuah (Kupat Tahu)' => [
                        ['type' => 'image', 'content' => 'magelang-kupat-tahu.jpg'],
                        ['type' => 'text', 'content' => 'Kupat Tahu Magelang'],
                        ['type' => 'text', 'content' => 'Kuah Kecap Manis'],
                    ],
                    'Trilogi Jajanan Tradisional (Gethuk)' => [
                        ['type' => 'image', 'content' => 'magelang-gethuk.jpg'],
                        ['type' => 'text', 'content' => 'Gethuk Trio'],
                        ['type' => 'text', 'content' => 'Olahan Singkong'],
                    ],
                ],
            ],
            [
                'stage_number' => 4,
                'name' => 'Stage 4 - Kudus',
                'city_name' => 'Kudus',
                'region' => 'Jawa Tengah',
                'map_pin_x' => 54,
                'map_pin_y' => 42,
                'trilogies' => [
                    'Trilogi Akulturasi Arsitektur (Menara Kudus)' => [
                        ['type' => 'image', 'content' => 'kudus-menara.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Menara Kudus'],
                        ['type' => 'text', 'content' => 'Akulturasi Hindu-Islam'],
                    ],
                    'Trilogi Tokoh Penyebar Agama (Sunan Kudus)' => [
                        ['type' => 'image', 'content' => 'kudus-sunan-kudus.jpg'],
                        ['type' => 'text', 'content' => 'Sunan Kudus'],
                        ['type' => 'text', 'content' => 'Wali Songo'],
                    ],
                    'Trilogi Kuliner Toleransi (Soto Kudus)' => [
                        ['type' => 'image', 'content' => 'kudus-soto.jpg'],
                        ['type' => 'text', 'content' => 'Soto Kudus'],
                        ['type' => 'text', 'content' => 'Daging Kerbau'],
                    ],
                    'Trilogi Sejarah Industri (Museum Kretek)' => [
                        ['type' => 'image', 'content' => 'kudus-museum-kretek.jpg'],
                        ['type' => 'text', 'content' => 'Museum Kretek'],
                        ['type' => 'text', 'content' => 'Kota Kretek'],
                    ],
                    'Trilogi Oleh-oleh Khas (Jenang)' => [
                        ['type' => 'image', 'content' => 'kudus-jenang.jpg'],
                        ['type' => 'text', 'content' => 'Jenang Kudus'],
                        ['type' => 'text', 'content' => 'Oleh-oleh Manis Legit'],
                    ],
                    'Trilogi Alam & Religi (Gunung Muria)' => [
                        ['type' => 'image', 'content' => 'kudus-gunung-muria.jpg'],
                        ['type' => 'text', 'content' => 'Gunung Muria'],
                        ['type' => 'text', 'content' => 'Makam Sunan Muria'],
                    ],
                ],
            ],
            [
                'stage_number' => 5,
                'name' => 'Stage 5 - Jepara',
                'city_name' => 'Jepara',
                'region' => 'Jawa Tengah',
                'map_pin_x' => 59,
                'map_pin_y' => 41,
                'trilogies' => [
                    'Trilogi Pahlawan Emansipasi (R.A. Kartini)' => [
                        ['type' => 'image', 'content' => 'jepara-kartini.jpg'],
                        ['type' => 'text', 'content' => 'R.A. Kartini'],
                        ['type' => 'text', 'content' => 'Habis Gelap Terbitlah Terang'],
                    ],
                    'Trilogi Ekraf / Ekonomi Kreatif (Seni Ukir)' => [
                        ['type' => 'image', 'content' => 'jepara-ukir-kayu.jpg'],
                        ['type' => 'text', 'content' => 'Seni Ukir Kayu'],
                        ['type' => 'text', 'content' => 'Kota Ukir Dunia'],
                    ],
                    'Trilogi Wisata Bahari (Karimunjawa)' => [
                        ['type' => 'image', 'content' => 'jepara-karimunjawa.jpg'],
                        ['type' => 'text', 'content' => 'Kepulauan Karimunjawa'],
                        ['type' => 'text', 'content' => 'Taman Nasional Laut'],
                    ],
                    'Trilogi Benteng Bersejarah (Benteng Portugis)' => [
                        ['type' => 'image', 'content' => 'jepara-benteng-portugis.jpg'],
                        ['type' => 'text', 'content' => 'Benteng Portugis'],
                        ['type' => 'text', 'content' => 'Pengintai Kapal Asing'],
                    ],
                    'Trilogi Makanan Laut (Pindang Serani)' => [
                        ['type' => 'image', 'content' => 'jepara-pindang-serani.jpg'],
                        ['type' => 'text', 'content' => 'Pindang Serani'],
                        ['type' => 'text', 'content' => 'Sup Ikan Laut'],
                    ],
                    'Trilogi Ikon Pariwisata (Kura-Kura Ocean Park)' => [
                        ['type' => 'image', 'content' => 'jepara-kura-kura-ocean-park.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Kartini'],
                        ['type' => 'text', 'content' => 'Kura-kura Ocean Park'],
                    ],
                ],
            ],
        ];
    }
}
