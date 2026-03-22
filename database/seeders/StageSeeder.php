<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Stage;
use App\Models\Topic;
use Illuminate\Database\Seeder;

/**
 * Semua stage konten (Jawa 1–9, Kalimantan 10–14).
 * Pin map: persen relatif ke gambar pulau (jawa.png).
 *
 * Setelah mengubah isi seeder ini, jalankan:
 *   php artisan db:seed --class=StageSeeder
 * agar database ikut berubah (bukan otomatis saat save file).
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

            // Hapus kartu lama lalu isi ulang = edit seeder + seed → DB selaras (firstOrCreate tidak pernah update baris lama).
            $topic->cards()->delete();

            foreach ($cards as $card) {
                Card::query()->create([
                    'topic_id' => $topic->id,
                    'type' => $card['type'],
                    'content' => $card['content'],
                ]);
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
                /* Pantai utara — geser ke bawah (y↑) supaya di daratan, bukan di laut */
                'map_pin_x' => 53,
                'map_pin_y' => 47,
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
                /* Timur Magelang & Yogya — bukan utara Semarang */
                'map_pin_x' => 56.5,
                'map_pin_y' => 57,
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
                /* Selatan Semarang — antara Semarang–Solo */
                'map_pin_x' => 51,
                'map_pin_y' => 59,
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
                'map_pin_x' => 57.2,
                'map_pin_y' => 44.8,
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
                'map_pin_x' => 56,
                'map_pin_y' => 40,
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
                        ['type' => 'text', 'content' => 'Pulau Laut Indah'],
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
                        ['type' => 'image', 'content' => 'jepara-park.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Kartini'],
                        ['type' => 'text', 'content' => 'Kura-kura Ocean Park'],
                    ],
                ],
            ],
            [
                'stage_number' => 6,
                'name' => 'Stage 6 - Medan',
                'city_name' => 'Medan',
                'region' => 'Sumatera',
                'map_pin_x' => 39,
                'map_pin_y' => 25,
                'trilogies' => [
                    'Landmark & Sejarah (Istana Maimun)' => [
                        ['type' => 'image', 'content' => 'istana-maimun.jpeg'],
                        ['type' => 'text', 'content' => 'Istana Maimun'],
                        ['type' => 'text', 'content' => 'Kesultanan Deli'],
                    ],
                    'Monumen Agama (Masjid Raya)' => [
                        ['type' => 'image', 'content' => 'masjid-raya-medan.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Raya'],
                        ['type' => 'text', 'content' => 'Arsitektur Megah'],
                    ],
                    'Kuliner Manis (Bika Ambon)' => [
                        ['type' => 'image', 'content' => 'bika-ambon.jpg'],
                        ['type' => 'text', 'content' => 'Bika Ambon'],
                        ['type' => 'text', 'content' => 'Kue Berongga'],
                    ],
                    'Kuliner Berkuah (Soto Medan)' => [
                        ['type' => 'image', 'content' => 'soto-medan.jpg'],
                        ['type' => 'text', 'content' => 'Soto Medan'],
                        ['type' => 'text', 'content' => 'Kuah Santan'],
                    ],
                    'Danau Vulkanik (Danau Toba)' => [
                        ['type' => 'image', 'content' => 'danau-toba.jpg'],
                        ['type' => 'text', 'content' => 'Danau Toba'],
                        ['type' => 'text', 'content' => 'Danau Vulkanik'],
                    ],
                    'Pulau Tengah Danau (Samosir)' => [
                        ['type' => 'image', 'content' => 'pulau-samosir.jpeg'],
                        ['type' => 'text', 'content' => 'Samosir'],
                        ['type' => 'text', 'content' => 'Pulau Tengah Danau'],
                    ],
                    'Sejarah Tionghoa (Tjong A Fie)' => [
                        ['type' => 'image', 'content' => 'tjong-a-fie.jpg'],
                        ['type' => 'text', 'content' => 'Tjong A Fie'],
                        ['type' => 'text', 'content' => 'Sejarah Tionghoa'],
                    ],
                    'Pusat Kuliner (Merdeka Walk)' => [
                        ['type' => 'image', 'content' => 'merdeka-walk.jpg'],
                        ['type' => 'text', 'content' => 'Merdeka Walk'],
                        ['type' => 'text', 'content' => 'Pusat Kuliner'],
                    ],
                    'Galeri Satwa (Rahmat Gallery)' => [
                        ['type' => 'image', 'content' => 'rahmat-gallery.jpeg'],
                        ['type' => 'text', 'content' => 'Rahmat Gallery'],
                        ['type' => 'text', 'content' => 'Galeri Satwa'],
                    ],
                    'Buah Ikonik (Durian)' => [
                        ['type' => 'image', 'content' => 'durian-medan.jpg'],
                        ['type' => 'text', 'content' => 'Durian'],
                        ['type' => 'text', 'content' => 'Buah Ikonik, Aroma Tajam'],
                    ],
                ],
            ],
            [
                'stage_number' => 7,
                'name' => 'Stage 7 - Palembang',
                'city_name' => 'Palembang',
                'region' => 'Sumatera',
                'map_pin_x' => 65,
                'map_pin_y' => 71,
                'trilogies' => [
                    'Gerbang Musi (Ampera)' => [
                        ['type' => 'image', 'content' => 'jembatan-ampera.png'],
                        ['type' => 'text', 'content' => 'Ampera'],
                        ['type' => 'text', 'content' => 'Gerbang Musi'],
                    ],
                    'Kuliner Ikan (Pempek)' => [
                        ['type' => 'image', 'content' => 'pempek.jpg'],
                        ['type' => 'text', 'content' => 'Pempek'],
                        ['type' => 'text', 'content' => 'Kuah Cuko'],
                    ],
                    'Sungai Besar (Musi)' => [
                        ['type' => 'image', 'content' => 'sungai-musi.jpg'],
                        ['type' => 'text', 'content' => 'Musi'],
                        ['type' => 'text', 'content' => 'Sungai Besar'],
                    ],
                    'Benteng Bersejarah (Kuto Besak)' => [
                        ['type' => 'image', 'content' => 'kuto-besak.jpg'],
                        ['type' => 'text', 'content' => 'Benteng'],
                        ['type' => 'text', 'content' => 'Benteng Bersejarah'],
                    ],
                    'Kuliner Udang (Tekwan)' => [
                        ['type' => 'image', 'content' => 'tekwan.jpg'],
                        ['type' => 'text', 'content' => 'Tekwan'],
                        ['type' => 'text', 'content' => 'Kuah Udang'],
                    ],
                    'Legenda Cinta (Pulau Kemaro)' => [
                        ['type' => 'image', 'content' => 'pulau-kemaro.jpg'],
                        ['type' => 'text', 'content' => 'Kemaro'],
                        ['type' => 'text', 'content' => 'Legenda Cinta'],
                    ],
                    'Religi (Masjid Agung)' => [
                        ['type' => 'image', 'content' => 'masjid-agung-palembang.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Agung'],
                        ['type' => 'text', 'content' => 'Religi'],
                    ],
                    'Kompleks Olahraga (Jakabaring)' => [
                        ['type' => 'image', 'content' => 'jakabaring.jpg'],
                        ['type' => 'text', 'content' => 'Jakabaring'],
                        ['type' => 'text', 'content' => 'Kompleks Olahraga'],
                    ],
                    'Ikan Kuah (Model)' => [
                        ['type' => 'image', 'content' => 'model.jpg'],
                        ['type' => 'text', 'content' => 'Model'],
                        ['type' => 'text', 'content' => 'Ikan Kuah'],
                    ],
                    'Ikan Asam Pedas (Pindang Patin)' => [
                        ['type' => 'image', 'content' => 'pindang-patin.jpg'],
                        ['type' => 'text', 'content' => 'Pindang'],
                        ['type' => 'text', 'content' => 'Ikan Asam Pedas'],
                    ],
                ],
            ],
            [
                'stage_number' => 8,
                'name' => 'Stage 8 - Yogyakarta',
                'city_name' => 'Yogyakarta',
                'region' => 'DI Yogyakarta',
                /* Barat daya Solo (bukan tegak selatan) */
                'map_pin_x' => 53,
                'map_pin_y' => 64.5,
                'trilogies' => [
                    'Trilogi Pusat Kesultanan (Keraton Ngayogyakarta)' => [
                        ['type' => 'image', 'content' => 'jogja-keraton.jpg'],
                        ['type' => 'text', 'content' => 'Keraton Ngayogyakarta'],
                        ['type' => 'text', 'content' => 'Sri Sultan Hamengkubuwono'],
                    ],
                    'Trilogi Jantung Kota (Malioboro)' => [
                        ['type' => 'image', 'content' => 'jogja-malioboro.jpg'],
                        ['type' => 'text', 'content' => 'Jalan Malioboro'],
                        ['type' => 'text', 'content' => 'Sumbu Filosofis Jogja'],
                    ],
                    'Trilogi Legenda Candi (Prambanan)' => [
                        ['type' => 'image', 'content' => 'jogja-prambanan.jpg'],
                        ['type' => 'text', 'content' => 'Candi Prambanan'],
                        ['type' => 'text', 'content' => 'Legenda Roro Jonggrang'],
                    ],
                    'Trilogi Kuliner Ikonik (Gudeg)' => [
                        ['type' => 'image', 'content' => 'jogja-gudeg.jpg'],
                        ['type' => 'text', 'content' => 'Gudeg Jogja'],
                        ['type' => 'text', 'content' => 'Olahan Nangka Muda'],
                    ],
                    'Trilogi Arsitektur Kerajaan (Taman Sari)' => [
                        ['type' => 'image', 'content' => 'jogja-taman-sari.jpg'],
                        ['type' => 'text', 'content' => 'Taman Sari'],
                        ['type' => 'text', 'content' => 'Istana Air Kerajaan'],
                    ],
                    'Trilogi Landmark Bersejarah (Tugu Pal Putih)' => [
                        ['type' => 'image', 'content' => 'jogja-tugu.jpg'],
                        ['type' => 'text', 'content' => 'Tugu Pal Putih'],
                        ['type' => 'text', 'content' => 'Ikon Kota Pelajar'],
                    ],
                ],
            ],
            [
                'stage_number' => 9,
                'name' => 'Stage 9 - Jakarta',
                'city_name' => 'Jakarta',
                'region' => 'DKI Jakarta',
                /* Ujung barat daya Jabodetabek — lebih ke kiri (x↓) */
                'map_pin_x' => 23,
                'map_pin_y' => 35,
                'trilogies' => [
                    'Trilogi Monumen Ibu Kota (Monas)' => [
                        ['type' => 'image', 'content' => 'jakarta-monas.jpg'],
                        ['type' => 'text', 'content' => 'Monumen Nasional'],
                        ['type' => 'text', 'content' => 'Puncak Emas 38 Kg'],
                    ],
                    'Trilogi Kota Tua (Museum Fatahillah)' => [
                        ['type' => 'image', 'content' => 'jakarta-museum-fatahillah.jpg'],
                        ['type' => 'text', 'content' => 'Museum Fatahillah'],
                        ['type' => 'text', 'content' => 'Sejarah Batavia'],
                    ],
                    'Trilogi Ikon Budaya (Ondel-Ondel)' => [
                        ['type' => 'image', 'content' => 'jakarta-ondel-ondel.jpg'],
                        ['type' => 'text', 'content' => 'Ondel-Ondel'],
                        ['type' => 'text', 'content' => 'Boneka Raksasa Betawi'],
                    ],
                    'Trilogi Kuliner Asli (Kerak Telor)' => [
                        ['type' => 'image', 'content' => 'jakarta-kerak-telor.jpg'],
                        ['type' => 'text', 'content' => 'Kerak Telor'],
                        ['type' => 'text', 'content' => 'Beras Ketan & Telur Bebek'],
                    ],
                    'Trilogi Pelabuhan Bersejarah (Sunda Kelapa)' => [
                        ['type' => 'image', 'content' => 'jakarta-sunda-kelapa.jpg'],
                        ['type' => 'text', 'content' => 'Pelabuhan Sunda Kelapa'],
                        ['type' => 'text', 'content' => 'Kapal Kayu Pinisi'],
                    ],
                    'Trilogi Simbol Toleransi (Masjid Istiqlal)' => [
                        ['type' => 'image', 'content' => 'jakarta-istiqlal.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Istiqlal'],
                        ['type' => 'text', 'content' => 'Masjid Terbesar Asia Tenggara'],
                    ],
                ],
            ],
            [
                'stage_number' => 10,
                'name' => 'Stage 10 - Bandung',
                'city_name' => 'Bandung',
                'region' => 'Jawa Barat',
                /* Priangan — tenggara Jakarta */
                'map_pin_x' => 30.3,
                'map_pin_y' => 47,
                'trilogies' => [
                    'Trilogi Landmark Jabar (Gedung Sate)' => [
                        ['type' => 'image', 'content' => 'bandung-gedung-sate.jpg'],
                        ['type' => 'text', 'content' => 'Gedung Sate'],
                        ['type' => 'text', 'content' => 'Ornamen Tusuk Sate'],
                    ],
                    'Trilogi Sejarah Diplomasi (Gedung Merdeka)' => [
                        ['type' => 'image', 'content' => 'bandung-gedung-merdeka.jpg'],
                        ['type' => 'text', 'content' => 'Gedung Merdeka'],
                        ['type' => 'text', 'content' => 'Konferensi Asia Afrika'],
                    ],
                    'Trilogi Legenda Alam (Tangkuban Perahu)' => [
                        ['type' => 'image', 'content' => 'bandung-tangkuban-perahu.jpg'],
                        ['type' => 'text', 'content' => 'Tangkuban Perahu'],
                        ['type' => 'text', 'content' => 'Legenda Sangkuriang'],
                    ],
                    'Trilogi Kesenian Sunda (Angklung)' => [
                        ['type' => 'image', 'content' => 'bandung-angklung.jpg'],
                        ['type' => 'text', 'content' => 'Saung Angklung Udjo'],
                        ['type' => 'text', 'content' => 'Alat Musik Bambu'],
                    ],
                    'Trilogi Kuliner Jalanan (Batagor)' => [
                        ['type' => 'image', 'content' => 'bandung-batagor.jpg'],
                        ['type' => 'text', 'content' => 'Batagor Bandung'],
                        ['type' => 'text', 'content' => 'Bakso Tahu Goreng'],
                    ],
                    'Trilogi Monumen Perjuangan (Bandung Lautan Api)' => [
                        ['type' => 'image', 'content' => 'bandung-monumen-bla.jpg'],
                        ['type' => 'text', 'content' => 'Monumen BLA'],
                        ['type' => 'text', 'content' => 'Halo-Halo Bandung'],
                    ],
                ],
            ],
            [
                'stage_number' => 11,
                'name' => 'Stage 11 - Surabaya',
                'city_name' => 'Surabaya',
                'region' => 'Jawa Timur',
                /* Pantai utara Jatim — sama: y cukup besar biar di daratan */
                'map_pin_x' => 72,
                'map_pin_y' => 52,
                'trilogies' => [
                    'Trilogi Simbol Kota (Sura & Baya)' => [
                        ['type' => 'image', 'content' => 'surabaya-sura-baya.jpg'],
                        ['type' => 'text', 'content' => 'Patung Sura dan Baya'],
                        ['type' => 'text', 'content' => 'Ikon Kota Surabaya'],
                    ],
                    'Trilogi Monumen Perjuangan (Tugu Pahlawan)' => [
                        ['type' => 'image', 'content' => 'surabaya-tugu-pahlawan.jpg'],
                        ['type' => 'text', 'content' => 'Tugu Pahlawan'],
                        ['type' => 'text', 'content' => 'Pertempuran 10 November'],
                    ],
                    'Trilogi Infrastruktur Megah (Jembatan Suramadu)' => [
                        ['type' => 'image', 'content' => 'surabaya-suramadu.jpg'],
                        ['type' => 'text', 'content' => 'Jembatan Suramadu'],
                        ['type' => 'text', 'content' => 'Penghubung Jawa-Madura'],
                    ],
                    'Trilogi Wisata Maritim (Monumen Kapal Selam)' => [
                        ['type' => 'image', 'content' => 'surabaya-monkasel.jpg'],
                        ['type' => 'text', 'content' => 'Monkasel'],
                        ['type' => 'text', 'content' => 'KRI Pasopati 410'],
                    ],
                    'Trilogi Kuliner Kuah Gelap (Rawon)' => [
                        ['type' => 'image', 'content' => 'surabaya-rawon.jpg'],
                        ['type' => 'text', 'content' => 'Nasi Rawon'],
                        ['type' => 'text', 'content' => 'Kuah Hitam Kluwek'],
                    ],
                    'Trilogi Kuliner Ekstrem/Unik (Rujak Cingur)' => [
                        ['type' => 'image', 'content' => 'surabaya-rujak-cingur.jpg'],
                        ['type' => 'text', 'content' => 'Rujak Cingur'],
                        ['type' => 'text', 'content' => 'Olahan Moncong Sapi'],
                    ],
                ],
            ],
            [
                'stage_number' => 12,
                'name' => 'Stage 12 - Pontianak',
                'city_name' => 'Pontianak',
                'region' => 'Kalimantan Barat',
                'map_pin_x' => 36.5,
                'map_pin_y' => 61.5,
                'trilogies' => [
                    'Trilogi Geografi Dunia (Tugu Khatulistiwa)' => [
                        ['type' => 'image', 'content' => 'pontianak-tugu-khatulistiwa.jpg'],
                        ['type' => 'text', 'content' => 'Tugu Khatulistiwa'],
                        ['type' => 'text', 'content' => 'Garis Lintang Nol Derajat'],
                    ],
                    'Trilogi Urat Nadi Kota (Sungai Kapuas)' => [
                        ['type' => 'image', 'content' => 'pontianak-sungai-kapuas.jpg'],
                        ['type' => 'text', 'content' => 'Sungai Kapuas'],
                        ['type' => 'text', 'content' => 'Sungai Terpanjang Indonesia'],
                    ],
                    'Trilogi Minuman Khas (Lidah Buaya)' => [
                        ['type' => 'image', 'content' => 'pontianak-es-lidah-buaya.jpg'],
                        ['type' => 'text', 'content' => 'Es Lidah Buaya'],
                        ['type' => 'text', 'content' => 'Tanaman Aloe Vera'],
                    ],
                    'Trilogi Kuliner Peranakan (Choipan)' => [
                        ['type' => 'image', 'content' => 'pontianak-choipan.jpg'],
                        ['type' => 'text', 'content' => 'Kue Choi Pan'],
                        ['type' => 'text', 'content' => 'Kukusan Tepung Beras'],
                    ],
                    'Trilogi Budaya Nongkrong (Kopi Asiang)' => [
                        ['type' => 'image', 'content' => 'pontianak-kopi-asiang.jpg'],
                        ['type' => 'text', 'content' => 'Kopi Tiam Pontianak'],
                        ['type' => 'text', 'content' => 'Budaya Kopi Tarik'],
                    ],
                    'Trilogi Pusat Kesultanan (Istana Kadriah)' => [
                        ['type' => 'image', 'content' => 'pontianak-istana-kadriah.jpg'],
                        ['type' => 'text', 'content' => 'Istana Kadriah'],
                        ['type' => 'text', 'content' => 'Kesultanan Pontianak'],
                    ],
                ],
            ],
            [
                'stage_number' => 13,
                'name' => 'Stage 13 - Banjarmasin',
                'city_name' => 'Banjarmasin',
                'region' => 'Kalimantan Selatan',
                'map_pin_x' => 54.7,
                'map_pin_y' => 86,
                'trilogies' => [
                    'Trilogi Budaya Ekonomi (Pasar Terapung)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-pasar-terapung.jpg'],
                        ['type' => 'text', 'content' => 'Pasar Terapung'],
                        ['type' => 'text', 'content' => 'Transaksi di Atas Perahu'],
                    ],
                    'Trilogi Satwa Endemik (Bekantan)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-bekantan.jpg'],
                        ['type' => 'text', 'content' => 'Bekantan'],
                        ['type' => 'text', 'content' => 'Monyet Hidung Panjang'],
                    ],
                    'Trilogi Kuliner Kuah (Soto Banjar)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-soto-banjar.jpg'],
                        ['type' => 'text', 'content' => 'Soto Banjar'],
                        ['type' => 'text', 'content' => 'Kuah Rempah Susu & Ketupat'],
                    ],
                    'Trilogi Kain Tradisional (Sasirangan)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-sasirangan.jpg'],
                        ['type' => 'text', 'content' => 'Kain Sasirangan'],
                        ['type' => 'text', 'content' => 'Batik Khas Suku Banjar'],
                    ],
                    'Trilogi Arsitektur Adat (Bubungan Tinggi)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-bubungan-tinggi.jpg'],
                        ['type' => 'text', 'content' => 'Bubungan Tinggi'],
                        ['type' => 'text', 'content' => 'Rumah Adat Banjar'],
                    ],
                    'Trilogi Ikon Religi (Masjid Sabilal Muhtadin)' => [
                        ['type' => 'image', 'content' => 'banjarmasin-sabilal-muhtadin.jpg'],
                        ['type' => 'text', 'content' => 'Sabilal Muhtadin'],
                        ['type' => 'text', 'content' => 'Masjid Raya Banjarmasin'],
                    ],
                ],
            ],
            [
                'stage_number' => 14,
                'name' => 'Stage 14 - Balikpapan',
                'city_name' => 'Balikpapan',
                'region' => 'Kalimantan Timur',
                'map_pin_x' => 62.7,
                'map_pin_y' => 70,
                'trilogies' => [
                    'Trilogi Sejarah Industri (Sumur Mathilda)' => [
                        ['type' => 'image', 'content' => 'balikpapan-sumur-mathilda.jpg'],
                        ['type' => 'text', 'content' => 'Sumur Minyak Mathilda'],
                        ['type' => 'text', 'content' => 'Sejarah Kota Minyak'],
                    ],
                    'Trilogi Maskot Kota (Beruang Madu)' => [
                        ['type' => 'image', 'content' => 'balikpapan-beruang-madu.jpg'],
                        ['type' => 'text', 'content' => 'Beruang Madu'],
                        ['type' => 'text', 'content' => 'Maskot Kota Balikpapan'],
                    ],
                    'Trilogi Makanan Laut (Abon Kepiting)' => [
                        ['type' => 'image', 'content' => 'balikpapan-abon-kepiting.jpg'],
                        ['type' => 'text', 'content' => 'Abon Kepiting'],
                        ['type' => 'text', 'content' => 'Oleh-Oleh Khas Pesisir'],
                    ],
                    'Trilogi Hutan Lindung (Bukit Bangkirai)' => [
                        ['type' => 'image', 'content' => 'balikpapan-bukit-bangkirai.jpg'],
                        ['type' => 'text', 'content' => 'Bukit Bangkirai'],
                        ['type' => 'text', 'content' => 'Jembatan Tajuk Pohon'],
                    ],
                    'Trilogi Infrastruktur (Jembatan Pulau Balang)' => [
                        ['type' => 'image', 'content' => 'balikpapan-jembatan-balang.jpg'],
                        ['type' => 'text', 'content' => 'Jembatan Pulau Balang'],
                        ['type' => 'text', 'content' => 'Akses Darat Menuju IKN'],
                    ],
                    'Trilogi Wisata Tengah Kota (Pantai Melawai)' => [
                        ['type' => 'image', 'content' => 'balikpapan-pantai-melawai.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Melawai'],
                        ['type' => 'text', 'content' => 'Tempat Berburu Sunset'],
                    ],
                ],
            ],
            [
                'stage_number' => 15,
                'name' => 'Stage 15 - Samarinda',
                'city_name' => 'Samarinda',
                'region' => 'Kalimantan Timur',
                'map_pin_x' => 63,
                'map_pin_y' => 65,
                'trilogies' => [
                    'Trilogi Simbol Kota (Sungai Mahakam)' => [
                        ['type' => 'image', 'content' => 'samarinda-sungai-mahakam.jpg'],
                        ['type' => 'text', 'content' => 'Sungai Mahakam'],
                        ['type' => 'text', 'content' => 'Urat Nadi Kalimantan Timur'],
                    ],
                    'Trilogi Satwa Air Raksasa (Pesut)' => [
                        ['type' => 'image', 'content' => 'samarinda-pesut.jpg'],
                        ['type' => 'text', 'content' => 'Pesut Mahakam'],
                        ['type' => 'text', 'content' => 'Lumba-Lumba Air Tawar'],
                    ],
                    'Trilogi Jajanan Khas (Amplang)' => [
                        ['type' => 'image', 'content' => 'samarinda-amplang.jpg'],
                        ['type' => 'text', 'content' => 'Kerupuk Amplang'],
                        ['type' => 'text', 'content' => 'Olahan Ikan Tenggiri'],
                    ],
                    'Trilogi Kerajinan Tangan (Sarung Samarinda)' => [
                        ['type' => 'image', 'content' => 'samarinda-sarung.jpg'],
                        ['type' => 'text', 'content' => 'Sarung Samarinda'],
                        ['type' => 'text', 'content' => 'Tenun Alat Tradisional'],
                    ],
                    'Trilogi Ikon Religi (Islamic Center)' => [
                        ['type' => 'image', 'content' => 'samarinda-islamic-center.jpg'],
                        ['type' => 'text', 'content' => 'Islamic Center Samarinda'],
                        ['type' => 'text', 'content' => 'Masjid Megah Tepian'],
                    ],
                    'Trilogi Budaya Lokal (Desa Pampang)' => [
                        ['type' => 'image', 'content' => 'samarinda-desa-pampang.jpg'],
                        ['type' => 'text', 'content' => 'Desa Budaya Pampang'],
                        ['type' => 'text', 'content' => 'Suku Dayak Kenyah'],
                    ],
                ],
            ],
            [
                'stage_number' => 16,
                'name' => 'Stage 16 - Palangka Raya',
                'city_name' => 'Palangka Raya',
                'region' => 'Kalimantan Tengah',
                'map_pin_x' => 52,
                'map_pin_y' => 78,
                'trilogies' => [
                    'Trilogi Sejarah Pendirian (Tugu Soekarno)' => [
                        ['type' => 'image', 'content' => 'palangka-tugu-soekarno.jpg'],
                        ['type' => 'text', 'content' => 'Tugu Soekarno'],
                        ['type' => 'text', 'content' => 'Tiang Pancang Kota Pertama'],
                    ],
                    'Trilogi Infrastruktur Megah (Jembatan Kahayan)' => [
                        ['type' => 'image', 'content' => 'palangka-jembatan-kahayan.jpg'],
                        ['type' => 'text', 'content' => 'Jembatan Kahayan'],
                        ['type' => 'text', 'content' => 'Penghubung Suku Dayak'],
                    ],
                    'Trilogi Taman Nasional (Sebangau)' => [
                        ['type' => 'image', 'content' => 'palangka-sebangau.jpg'],
                        ['type' => 'text', 'content' => 'Taman Nasional Sebangau'],
                        ['type' => 'text', 'content' => 'Habitat Orangutan'],
                    ],
                    'Trilogi Pusaka Tradisional (Mandau)' => [
                        ['type' => 'image', 'content' => 'palangka-mandau.jpg'],
                        ['type' => 'text', 'content' => 'Senjata Mandau'],
                        ['type' => 'text', 'content' => 'Pusaka Suku Dayak'],
                    ],
                    'Trilogi Kuliner Ekstrem (Juhu Singkah)' => [
                        ['type' => 'image', 'content' => 'palangka-juhu-singkah.jpg'],
                        ['type' => 'text', 'content' => 'Juhu Singkah'],
                        ['type' => 'text', 'content' => 'Sayur Umbut Rotan'],
                    ],
                    'Trilogi Transportasi Unik (Susur Sungai)' => [
                        ['type' => 'image', 'content' => 'palangka-kelotok.jpg'],
                        ['type' => 'text', 'content' => 'Perahu Kelotok'],
                        ['type' => 'text', 'content' => 'Wisata Susur Sungai'],
                    ],
                ],
            ],
        ];
    }
}
