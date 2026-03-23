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
                'desc1' => 'Semarang merupakan ibu kota Provinsi Jawa Tengah yang berkembang sebagai pusat ekonomi, perdagangan, dan pemerintahan. Kota ini memiliki karakter unik melalui perpaduan kawasan kota lama dan perkembangan urban modern, dengan ikon seperti Lawang Sewu dan Kota Lama yang mencerminkan sejarah kolonial, serta Simpang Lima sebagai pusat aktivitas masyarakat yang dinamis.',
                'desc2' => 'Selain itu, Semarang dikenal dengan keberagaman budaya hasil pertemuan etnis Jawa dan Tionghoa, terlihat dari kawasan Pecinan dan Klenteng Sam Poo Kong sebagai simbol akulturasi. Di sisi lain, kekayaan kuliner seperti lumpia Semarang, tahu gimbal, dan wingko babat semakin memperkuat daya tarik kota ini, menjadikannya salah satu kota penting di Pulau Jawa dengan identitas yang lengkap.',
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
                'name' => 'Stage 2 - Jakarta',
                'city_name' => 'Jakarta',
                'region' => 'DKI Jakarta',
                'desc1' => 'Jakarta merupakan ibu kota negara Indonesia yang berperan sebagai pusat pemerintahan, ekonomi, dan kegiatan nasional. Kota ini menjadi wilayah metropolitan terbesar dengan aktivitas yang padat dan dinamis, mencerminkan perannya dalam berbagai sektor seperti bisnis, politik, dan budaya, dengan ikon seperti Monas dan kawasan bisnis modern yang memperkuat identitasnya.',
                'desc2' => 'Selain itu, Jakarta memiliki keberagaman budaya yang tinggi dengan berbagai suku dan latar belakang masyarakat yang hidup berdampingan. Perpaduan antara kawasan bersejarah seperti Kota Tua dan gedung modern menunjukkan perkembangan kota yang berkelanjutan. Kekayaan kuliner seperti kerak telor, soto Betawi, hingga hidangan dari berbagai daerah turut melengkapi karakter Jakarta sebagai pusat aktivitas dan wajah utama Indonesia.',
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
                'stage_number' => 3,
                'name' => 'Stage 3 - Bandung',
                'city_name' => 'Bandung',
                'region' => 'Jawa Barat',
                'desc1' => 'Bandung merupakan ibu kota Provinsi Jawa Barat yang dikenal sebagai pusat kreativitas, pendidikan, dan pariwisata dengan suasana sejuk serta perkembangan urban yang dinamis. Ikon seperti Gedung Sate dan kawasan Braga mencerminkan perpaduan nilai sejarah dan gaya hidup modern yang membentuk karakter khas kota ini.',
                'desc2' => 'Selain itu, Bandung memiliki kekuatan di bidang industri kreatif dan pendidikan, didukung perguruan tinggi dan komunitas kreatif yang aktif, serta perkembangan sektor fesyen, kuliner, dan teknologi. Kekayaan kuliner seperti batagor, siomay, dan seblak turut memperkuat daya tariknya, menjadikan Bandung memiliki karakter kuat melalui perpaduan kreativitas, sejarah, dan kuliner.',
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
                'stage_number' => 4,
                'name' => 'Stage 4 - Surabaya',
                'city_name' => 'Surabaya',
                'region' => 'Jawa Timur',
                'desc1' => 'Surabaya merupakan ibu kota Provinsi Jawa Timur yang dikenal sebagai pusat ekonomi, perdagangan, dan industri besar di Indonesia. Kota ini memiliki peran penting dalam sejarah nasional sebagai kota perjuangan, dengan ikon seperti Tugu Pahlawan dan kawasan bersejarah yang memperkuat identitasnya sebagai kota sarat nilai historis.',
                'desc2' => 'Selain itu, Surabaya berkembang sebagai kota metropolitan dengan infrastruktur modern dan aktivitas yang dinamis, didukung pusat bisnis, pelabuhan, dan ruang publik yang terus tumbuh. Keberagaman budaya tetap terjaga, sementara kuliner khas seperti rawon, rujak cingur, dan lontong balap memperkuat identitas lokal, menjadikan Surabaya memiliki karakter yang menonjol melalui perpaduan sejarah, modernitas, dan kuliner.',
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
                'stage_number' => 5,
                'name' => 'Stage 5 - Yogyakarta',
                'city_name' => 'Yogyakarta',
                'region' => 'DI Yogyakarta',
                'desc1' => 'Yogyakarta merupakan ibu kota Provinsi Daerah Istimewa Yogyakarta yang dikenal sebagai pusat budaya, pendidikan, dan pariwisata di Indonesia. Identitasnya berakar dari sejarah Keraton Yogyakarta sebagai simbol pemerintahan dan kebudayaan Jawa, diperkuat oleh Malioboro sebagai pusat wisata dan Tugu Yogyakarta sebagai ikon kota yang mencerminkan karakter khasnya.',
                'desc2' => 'Selain itu, Yogyakarta dikenal sebagai kota pelajar dengan banyak institusi pendidikan serta kehidupan seni dan budaya yang berkembang pesat melalui pertunjukan dan kegiatan kreatif. Kekayaan kuliner seperti gudeg, bakpia, dan jajanan tradisional turut melengkapi daya tariknya, menjadikan kota ini memiliki karakter kuat melalui perpaduan budaya, pendidikan, dan kuliner.',
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
                'stage_number' => 6,
                'name' => 'Stage 6 - Bali',
                'city_name' => 'Bali',
                'region' => 'Bali',
                'desc1' => 'Bali merupakan salah satu provinsi di Indonesia yang memadukan keindahan alam, kekayaan budaya, dan daya tarik wisata kelas dunia. Ikon seperti Pantai Kuta, Tanah Lot, dan Garuda Wisnu Kencana mencerminkan karakter pulau yang kuat, dengan perpaduan antara panorama alam, nilai sakral, dan simbol budaya yang megah.',
                'desc2' => 'Selain itu, Bali dikenal dengan kehidupan seni dan tradisi yang kental, terutama di Ubud sebagai pusat budaya, serta Pura Besakih yang menunjukkan kedalaman spiritual masyarakatnya. Berbagai destinasi seperti Seminyak, Nusa Dua, dan Kintamani hingga Ulun Danu Beratan, serta kuliner khas seperti babi guling, melengkapi daya tariknya, menjadikan Bali sebagai wilayah dengan pengalaman wisata yang utuh dan beragam.',
                'map_pin_x' => 20,
                'map_pin_y' => 46,
                'trilogies' => [
                    'Pantai Ikonik (Kuta)' => [
                        ['type' => 'image', 'content' => 'pantai-kuta.jpg'],
                        ['type' => 'text', 'content' => 'Kuta'],
                        ['type' => 'text', 'content' => 'Pantai Ikonik'],
                    ],
                    'Pura Laut (Tanah Lot)' => [
                        ['type' => 'image', 'content' => 'tanah-lot.jpg'],
                        ['type' => 'text', 'content' => 'Pura Laut'],
                        ['type' => 'text', 'content' => 'Ikon Bali'],
                    ],
                    'Patung Raksasa (GWK)' => [
                        ['type' => 'image', 'content' => 'gwk.jpg'],
                        ['type' => 'text', 'content' => 'Patung'],
                        ['type' => 'text', 'content' => 'Wisnu Raksasa'],
                    ],
                    'Seni & Budaya (Ubud)' => [
                        ['type' => 'image', 'content' => 'ubud.jpg'],
                        ['type' => 'text', 'content' => 'Seni'],
                        ['type' => 'text', 'content' => 'Budaya Bali'],
                    ],
                    'Kuliner Khas (Babi Guling)' => [
                        ['type' => 'image', 'content' => 'babi-guling.jpg'],
                        ['type' => 'text', 'content' => 'Babi'],
                        ['type' => 'text', 'content' => 'Kuliner Khas'],
                    ],
                    'Pura Agung (Pura Besakih)' => [
                        ['type' => 'image', 'content' => 'pura-besakih.jpg'],
                        ['type' => 'text', 'content' => 'Pura'],
                        ['type' => 'text', 'content' => 'Pura Agung'],
                    ],
                    'Wisata Modern (Seminyak)' => [
                        ['type' => 'image', 'content' => 'seminyak.jpg'],
                        ['type' => 'text', 'content' => 'Wisata'],
                        ['type' => 'text', 'content' => 'Wisata Modern'],
                    ],
                    'Pantai Eksklusif (Nusa Dua)' => [
                        ['type' => 'image', 'content' => 'nusa-dua.jpg'],
                        ['type' => 'text', 'content' => 'Resort'],
                        ['type' => 'text', 'content' => 'Pantai Eksklusif'],
                    ],
                    'Pura Danau (Ulun Danu)' => [
                        ['type' => 'image', 'content' => 'ulundanu.jpg'],
                        ['type' => 'text', 'content' => 'Danau'],
                        ['type' => 'text', 'content' => 'Pura Danau'],
                    ],
                    'Panorama Gunung (Kintamani)' => [
                        ['type' => 'image', 'content' => 'kintamani.jpg'],
                        ['type' => 'text', 'content' => 'Gunung Batur'],
                        ['type' => 'text', 'content' => 'Panorama Gunung'],
                    ],
                    'Tarian Ritual (Kecak)' => [
                        ['type' => 'image', 'content' => 'tari-kecak.jpg'],
                        ['type' => 'text', 'content' => 'Tari Kecak'],
                        ['type' => 'text', 'content' => 'Tarian Ritual'],
                    ],
                ],
            ],
            [
                'stage_number' => 7,
                'name' => 'Stage 7 - Solo',
                'city_name' => 'Solo',
                'region' => 'Jawa Tengah',
                'desc1' => 'Solo atau Surakarta merupakan salah satu kota di Provinsi Jawa Tengah yang dikenal sebagai pusat budaya Jawa yang masih terjaga kuat. Identitas kota ini erat dengan Keraton Surakarta dan Pura Mangkunegaran sebagai simbol sejarah dan tradisi, serta kehidupan masyarakat yang mencerminkan nilai budaya Jawa dalam seni, adat, dan keseharian.',
                'desc2' => 'Selain itu, Solo berkembang sebagai kota yang dinamis dengan perpaduan tradisi dan modernitas, terlihat dari pelestarian seni seperti batik, wayang, dan musik tradisional serta pertumbuhan sektor perdagangan dan pariwisata. Kekayaan kuliner seperti nasi liwet, tengkleng, dan serabi Solo turut memperkuat daya tariknya, menjadikan kota ini memiliki karakter kuat melalui kombinasi budaya, sejarah, dan kuliner.',
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
                'stage_number' => 8,
                'name' => 'Stage 8 - Medan',
                'city_name' => 'Medan',
                'region' => 'Sumatra Utara',
                'desc1' => 'Medan adalah ibu kota Provinsi Sumatra Utara yang berperan sebagai pusat ekonomi, budaya, dan pariwisata. Keberagaman etnis serta warisan sejarah tercermin dalam bangunan ikonik dan perkembangan kotanya yang dinamis, membentuk karakter urban yang kuat sekaligus kaya nilai historis.',
                'desc2' => 'Kota ini juga dikenal sebagai destinasi kuliner penting di Indonesia bagian barat dengan ragam hidangan tradisional hingga modern. Didukung aktivitas perdagangan, jasa, dan pariwisata, Medan menjadi pintu gerbang utama menuju berbagai destinasi di Sumatra Utara, termasuk Danau Toba dan Pulau Samosir yang sering menjadi tujuan lanjutan wisatawan.',
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
                'stage_number' => 9,
                'name' => 'Stage 9 - Makassar',
                'city_name' => 'Makassar',
                'region' => 'Sulawesi Selatan',
                'desc1' => 'Makassar merupakan salah satu kota di Provinsi Sulawesi Selatan yang dikenal sebagai pusat ekonomi, perdagangan, dan pelabuhan di kawasan timur Indonesia. Kota ini memiliki peran penting sebagai pintu gerbang distribusi barang dan jasa, dengan perkembangan urban yang dinamis serta aktivitas masyarakat yang tinggi di berbagai sektor.',
                'desc2' => 'Selain itu, Makassar memiliki kekayaan sejarah dan budaya yang tercermin dari keberadaan Benteng Rotterdam sebagai salah satu ikon utama peninggalan kolonial yang masih terawat. Kehadiran situs bersejarah ini, bersama dengan kekayaan kuliner dan budaya lokal, menjadikan Makassar memiliki karakter kuat melalui perpaduan sejarah, aktivitas ekonomi, dan kehidupan masyarakat yang beragam.',
                'map_pin_x' => 40,
                'map_pin_y' => 83,
                'trilogies' => [
                    'Sunset Kota (Pantai Losari)' => [
                        ['type' => 'image', 'content' => 'pantai-losari.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Losari'],
                        ['type' => 'text', 'content' => 'Sunset Kota'],
                    ],
                    'Sejarah Kolonial (Benteng Rotterdam)' => [
                        ['type' => 'image', 'content' => 'benteng-rotterdam.png'],
                        ['type' => 'text', 'content' => 'Benteng Rotterdam'],
                        ['type' => 'text', 'content' => 'Sejarah Kolonial'],
                    ],
                    'Kuliner Daging Sapi (Coto Makassar)' => [
                        ['type' => 'image', 'content' => 'coto-makassar.jpg'],
                        ['type' => 'text', 'content' => 'Coto Makassar'],
                        ['type' => 'text', 'content' => 'Daging Sapi'],
                    ],
                    'Kuliner Iga Sapi (Konro)' => [
                        ['type' => 'image', 'content' => 'konro.jpg'],
                        ['type' => 'text', 'content' => 'Konro'],
                        ['type' => 'text', 'content' => 'Iga Sapi'],
                    ],
                    'Wisata Laut (Pulau Samalona)' => [
                        ['type' => 'image', 'content' => 'pulau-samalona.jpg'],
                        ['type' => 'text', 'content' => 'Pulau Samalona'],
                        ['type' => 'text', 'content' => 'Wisata Laut'],
                    ],
                    'Kapal Pinisi (Paotere)' => [
                        ['type' => 'image', 'content' => 'paotere.jpg'],
                        ['type' => 'text', 'content' => 'Paotere'],
                        ['type' => 'text', 'content' => 'Kapal Pinisi'],
                    ],
                    'Pantai Rekreasi (Pantai Akkarena)' => [
                        ['type' => 'image', 'content' => 'pantai-akkarena.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Akkarena'],
                        ['type' => 'text', 'content' => 'Pantai Rekreasi'],
                    ],
                ],
            ],
            [
                'stage_number' => 10,
                'name' => 'Stage 10 - Palembang',
                'city_name' => 'Palembang',
                'region' => 'Sumatra Selatan',
                'desc1' => 'Palembang merupakan ibu kota Provinsi Sumatra Selatan yang berkembang sebagai pusat sejarah, budaya, dan ekonomi. Letaknya di sepanjang Sungai Musi memberi peran penting sejak masa lampau, dengan berbagai peninggalan sejarah yang masih bertahan. Identitas kota terbentuk dari perpaduan warisan budaya, perkembangan urban, dan kehidupan masyarakat yang dinamis.',
                'desc2' => 'Perkembangannya terlihat dari infrastruktur modern serta peran dalam ajang nasional dan internasional seperti Asian Games dan SEA Games, didukung kawasan olahraga terpadu. Aktivitas masyarakat yang erat dengan sungai, pusat ekonomi, dan religi memperkuat karakter kota yang terus bertumbuh. Selain itu, Palembang dikenal sebagai destinasi kuliner khas berbasis ikan dengan cita rasa lokal yang kuat, menjadikannya memiliki identitas regional dan nasional yang menonjol.',
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
                        ['type' => 'text', 'content' => 'Kuto Besak'],
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
                'stage_number' => 11,
                'name' => 'Stage 11 - Padang',
                'city_name' => 'Padang',
                'region' => 'Sumatra Barat',
                'desc1' => 'Padang merupakan ibu kota Provinsi Sumatra Barat yang menjadi pusat ekonomi, budaya, dan pariwisata, dengan identitas kuat budaya Minangkabau yang tercermin dalam kehidupan masyarakat, arsitektur, dan tradisi. Letaknya di pesisir barat Sumatra menjadikannya wilayah strategis dengan dinamika perdagangan dan interaksi yang terus berkembang.',
                'desc2' => 'Kota ini juga dikenal secara global melalui kekayaan kulinernya seperti rendang, sate Padang, dan dendeng balado yang bercita rasa rempah kuat. Selain itu, Padang berperan sebagai representasi budaya Minangkabau, termasuk dalam seni seperti Tari Piring dari Solok, menjadikannya etalase tradisi dan seni budaya di tingkat regional dan nasional.',
                'map_pin_x' => 45,
                'map_pin_y' => 45,
                'trilogies' => [
                    'Kuliner Khas (Rendang)' => [
                        ['type' => 'image', 'content' => 'rendang.jpg'],
                        ['type' => 'text', 'content' => 'Rendang'],
                        ['type' => 'text', 'content' => 'Daging Sapi'],
                    ],
                    'Kuliner Berkuah (Sate Padang)' => [
                        ['type' => 'image', 'content' => 'sate-padang.jpg'],
                        ['type' => 'text', 'content' => 'Sate Padang'],
                        ['type' => 'text', 'content' => 'Kuah Kental'],
                    ],
                    'Wisata Pantai (Pantai Padang)' => [
                        ['type' => 'image', 'content' => 'pantai-padang.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Padang'],
                        ['type' => 'text', 'content' => 'Tepi Samudra'],
                    ],
                    'Legenda Malin Kundang (Pantai Air Manis)' => [
                        ['type' => 'image', 'content' => 'pantai-air-manis.jpg'],
                        ['type' => 'text', 'content' => 'Air Manis'],
                        ['type' => 'text', 'content' => 'Malin Kundang'],
                    ],
                    'Ikon Sungai (Jembatan Siti Nurbaya)' => [
                        ['type' => 'image', 'content' => 'jembatan-sitinurbaya.jpeg'],
                        ['type' => 'text', 'content' => 'Jembatan Siti Nurbaya'],
                        ['type' => 'text', 'content' => 'Ikon Sungai'],
                    ],
                    'Arsitektur Unik (Masjid Raya Sumbar)' => [
                        ['type' => 'image', 'content' => 'masjid-raya-sumbar.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Raya'],
                        ['type' => 'text', 'content' => 'Arsitektur Unik'],
                    ],
                    'Pelabuhan Bersejarah (Teluk Bayur)' => [
                        ['type' => 'image', 'content' => 'pelabuhan-teluk-bayur.jpg'],
                        ['type' => 'text', 'content' => 'Teluk Bayur'],
                        ['type' => 'text', 'content' => 'Pelabuhan'],
                    ],
                    'Pusat Kota (Pasar Raya Padang)' => [
                        ['type' => 'image', 'content' => 'pasar-raya-padang.jpg'],
                        ['type' => 'text', 'content' => 'Pasar Raya'],
                        ['type' => 'text', 'content' => 'Pusat Kota'],
                    ],
                    'Kuliner Pedas (Dendeng Balado)' => [
                        ['type' => 'image', 'content' => 'dendeng-balado.jpg'],
                        ['type' => 'text', 'content' => 'Dendeng Balado'],
                        ['type' => 'text', 'content' => 'Pedas'],
                    ],
                    'Tarian Tradisional (Tari Piring)' => [
                        ['type' => 'image', 'content' => 'tari-piring.jpg'],
                        ['type' => 'text', 'content' => 'Tari Piring'],
                        ['type' => 'text', 'content' => 'Tarian Tradisional'],
                    ],
                ],
            ],
            [
                'stage_number' => 12,
                'name' => 'Stage 12 - Manado',
                'city_name' => 'Manado',
                'region' => 'Sulawesi Utara',
                'desc1' => 'Manado merupakan ibu kota Provinsi Sulawesi Utara yang dikenal sebagai pusat pemerintahan, perdagangan, dan pariwisata di kawasan tersebut. Kota ini memiliki letak strategis di pesisir utara Sulawesi dengan panorama laut yang indah, serta menjadi pintu gerbang menuju berbagai destinasi wisata alam unggulan.',
                'desc2' => 'Selain itu, Manado dikenal dengan keberagaman budaya dan masyarakatnya yang harmonis, serta kekayaan kuliner khas yang terkenal dengan cita rasa kuat seperti tinutuan dan ikan cakalang. Kedekatan dengan destinasi wisata bahari seperti Bunaken juga memperkuat identitasnya, menjadikan Manado memiliki karakter yang kuat melalui perpaduan alam, budaya, dan kehidupan kota yang dinamis.',
                'map_pin_x' => 64,
                'map_pin_y' => 16,
                'trilogies' => [
                    'Surga Bawah Laut (Bunaken)' => [
                        ['type' => 'image', 'content' => 'bunaken.jpg'],
                        ['type' => 'text', 'content' => 'Bunaken'],
                        ['type' => 'text', 'content' => 'Surga Bawah Laut'],
                    ],
                    'Gunung Aktif (Gunung Lokon)' => [
                        ['type' => 'image', 'content' => 'gunung-lokon.jpg'],
                        ['type' => 'text', 'content' => 'Lokon'],
                        ['type' => 'text', 'content' => 'Gunung Aktif'],
                    ],
                    'Danau Vulkanik (Danau Tondano)' => [
                        ['type' => 'image', 'content' => 'danau-tondano.jpeg'],
                        ['type' => 'text', 'content' => 'Tondano'],
                        ['type' => 'text', 'content' => 'Danau Vulkanik'],
                    ],
                    'Pulau Tropis (Pulau Siladen)' => [
                        ['type' => 'image', 'content' => 'pulau-siladen.jpeg'],
                        ['type' => 'text', 'content' => 'Siladen'],
                        ['type' => 'text', 'content' => 'Pulau Tropis'],
                    ],
                    'Pusat Kota (Boulevard)' => [
                        ['type' => 'image', 'content' => 'boulevard.jpg'],
                        ['type' => 'text', 'content' => 'Boulevard'],
                        ['type' => 'text', 'content' => 'Pusat Kota'],
                    ],
                    'Religi Tionghoa (Ban Hin Kiong)' => [
                        ['type' => 'image', 'content' => 'ban-hin-kiong.jpg'],
                        ['type' => 'text', 'content' => 'Ban Hin Kiong'],
                        ['type' => 'text', 'content' => 'Religi Tionghoa'],
                    ],
                    'Bubur Manado (Tinutuan)' => [
                        ['type' => 'image', 'content' => 'tinutuan.jpeg'],
                        ['type' => 'text', 'content' => 'Tinutuan'],
                        ['type' => 'text', 'content' => 'Bubur Manado'],
                    ],
                    'Ikan Asap (Cakalang Fufu)' => [
                        ['type' => 'image', 'content' => 'cakalang-fufu.png'],
                        ['type' => 'text', 'content' => 'Cakalang'],
                        ['type' => 'text', 'content' => 'Ikan Asap'],
                    ],
                ],
            ],
            [
                'stage_number' => 13,
                'name' => 'Stage 13 - Balikpapan',
                'city_name' => 'Balikpapan',
                'region' => 'Kalimantan Timur',
                'desc1' => 'Balikpapan merupakan salah satu kota di Provinsi Kalimantan Timur yang dikenal sebagai pusat industri dan energi, terutama dalam sektor minyak dan gas. Perkembangan kota ini didukung oleh infrastruktur yang relatif modern serta tata kota yang tertata, menjadikannya salah satu kota dengan tingkat kenyamanan tinggi di Kalimantan.',
                'desc2' => 'Selain itu, Balikpapan memiliki lingkungan yang masih terjaga dengan kawasan hutan dan pesisir yang menjadi bagian dari identitasnya. Aktivitas ekonomi yang kuat berpadu dengan kesadaran terhadap kelestarian alam, serta keberagaman budaya dan kuliner, menjadikan kota ini memiliki karakter yang seimbang antara industri, lingkungan, dan kehidupan masyarakat.',
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
                'stage_number' => 14,
                'name' => 'Stage 14 - Samarinda',
                'city_name' => 'Samarinda',
                'region' => 'Kalimantan Timur',
                'desc1' => 'Samarinda merupakan ibu kota Provinsi Kalimantan Timur yang dikenal sebagai pusat pemerintahan, perdagangan, dan aktivitas ekonomi di wilayah tersebut. Kota ini berkembang di sepanjang Sungai Mahakam yang menjadi jalur utama transportasi dan kehidupan masyarakat, membentuk karakter kota yang erat dengan budaya sungai.',
                'desc2' => 'Selain itu, Samarinda memiliki keberagaman budaya yang tercermin dari kehidupan masyarakat multietnis yang hidup berdampingan. Aktivitas ekonomi yang dinamis, kekayaan kuliner lokal, serta perkembangan kota yang terus berlangsung menjadikan Samarinda memiliki karakter yang kuat melalui perpaduan budaya, perdagangan, dan kehidupan sungai.',
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
                'stage_number' => 15,
                'name' => 'Stage 15 - Pontianak',
                'city_name' => 'Pontianak',
                'region' => 'Kalimantan Barat',
                'desc1' => 'Pontianak merupakan ibu kota Provinsi Kalimantan Barat yang dikenal sebagai kota yang dilalui garis khatulistiwa, menjadikannya memiliki posisi geografis yang unik. Identitas kota ini tercermin dari Tugu Khatulistiwa sebagai ikon utama, serta peran Sungai Kapuas yang menjadi urat nadi kehidupan dan aktivitas masyarakat sejak dahulu.',
                'desc2' => 'Selain itu, Pontianak memiliki keberagaman budaya yang terbentuk dari perpaduan etnis Melayu, Tionghoa, dan Dayak. Kehidupan masyarakat yang dinamis, tradisi yang masih terjaga, serta kekayaan kuliner khas semakin memperkuat karakter kota ini, menjadikannya memiliki daya tarik tersendiri di Kalimantan Barat.',
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
                'stage_number' => 16,
                'name' => 'Stage 16 - Magelang',
                'city_name' => 'Magelang',
                'region' => 'Jawa Tengah',
                'desc1' => 'Magelang merupakan salah satu wilayah di Provinsi Jawa Tengah yang dikenal dengan perpaduan sejarah, budaya, dan letak geografis yang strategis. Kota dan kabupaten Magelang dikelilingi pegunungan yang menciptakan suasana sejuk serta lanskap khas, dengan Candi Borobudur sebagai ikon utama dan warisan budaya dunia yang melekat kuat pada identitas wilayah ini.',
                'desc2' => 'Selain itu, Magelang berkembang sebagai pusat pendidikan dan aktivitas militer serta daerah penyangga pariwisata, didukung destinasi alam seperti perbukitan dan pegunungan. Kekayaan budaya dan kuliner lokal yang mencerminkan kehidupan masyarakat Jawa turut memperkuat identitasnya, menjadikan Magelang memiliki karakter yang beragam melalui perpaduan sejarah, alam, dan tradisi.',
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
                'stage_number' => 17,
                'name' => 'Stage 17 - Jepara',
                'city_name' => 'Jepara',
                'region' => 'Jawa Tengah',
                'desc1' => 'Jepara merupakan salah satu kabupaten di Provinsi Jawa Tengah yang dikenal sebagai pusat seni ukir dan industri mebel bertaraf dunia. Identitas ini terbentuk dari tradisi panjang kerajinan kayu yang diwariskan turun-temurun, serta kaitannya dengan tokoh emansipasi wanita Indonesia, R.A. Kartini, yang memperkuat nilai sejarah daerah ini.',
                'desc2' => 'Di sisi lain, Jepara memiliki potensi wisata alam, terutama di kawasan pesisir seperti Kepulauan Karimunjawa dengan keindahan laut dan ekosistemnya. Selain itu, kekayaan budaya dan kuliner lokal turut memperkuat identitas daerah, menjadikan Jepara memiliki karakter yang kuat melalui perpaduan seni ukir, wisata bahari, dan tradisi.',
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
                'stage_number' => 18,
                'name' => 'Stage 18 - Kudus',
                'city_name' => 'Kudus',
                'region' => 'Jawa Tengah',
                'desc1' => 'Kudus merupakan salah satu kota di Provinsi Jawa Tengah yang dikenal sebagai pusat budaya dan religi dengan sejarah panjang dalam penyebaran Islam di Indonesia. Identitas kota tercermin dari Masjid Menara Kudus sebagai ikon utama yang memadukan arsitektur Islam dan Hindu, serta kehidupan masyarakat yang lekat dengan nilai keagamaan sebagai kota santri.',
                'desc2' => 'Di sisi lain, Kudus memiliki peran penting dalam industri, khususnya sebagai pusat rokok kretek, dengan aktivitas perdagangan dan ekonomi yang terus berkembang. Kekayaan kuliner seperti soto Kudus dan jenang Kudus turut memperkuat identitas lokal, menjadikan kota ini memiliki daya tarik unik melalui perpaduan sejarah religi, ekonomi, dan tradisi.',
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
                'stage_number' => 19,
                'name' => 'Stage 19 - Pekanbaru',
                'city_name' => 'Pekanbaru',
                'region' => 'Riau',
                'desc1' => 'Pekanbaru merupakan ibu kota Provinsi Riau yang dikenal sebagai pusat pemerintahan, ekonomi, dan perdagangan di wilayah tersebut. Kota ini berkembang pesat sebagai salah satu pusat industri dan jasa di Sumatra, didukung oleh letaknya yang strategis serta aktivitas ekonomi yang terus meningkat.',
                'desc2' => 'Selain itu, Pekanbaru memiliki keberagaman budaya yang terbentuk dari masyarakat Melayu sebagai identitas utama, berpadu dengan berbagai etnis lain yang hidup berdampingan. Tradisi Melayu masih sangat terasa dalam kehidupan sehari-hari, sementara kuliner khas dan perkembangan kota modern menjadikan Pekanbaru memiliki karakter yang kuat melalui perpaduan budaya, ekonomi, dan dinamika perkotaan.',
                'map_pin_x' => 50,
                'map_pin_y' => 40,
                'trilogies' => [
                    'Trilogi Ikon Kota (Menara Air)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-menara-air.jpg'],
                        ['type' => 'text', 'content' => 'Menara Air'],
                        ['type' => 'text', 'content' => 'Ikon Kota'],
                    ],
                    'Trilogi Arsitektur Melayu (Balai Adat)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-balai-adat.jpg'],
                        ['type' => 'text', 'content' => 'Balai Adat'],
                        ['type' => 'text', 'content' => 'Budaya Melayu'],
                    ],
                    'Trilogi Sungai (Sungai Siak)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-sungai-siak.jpg'],
                        ['type' => 'text', 'content' => 'Sungai Siak'],
                        ['type' => 'text', 'content' => 'Urat Nadi Kota'],
                    ],
                    'Trilogi Kuliner (Mie Lendir)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-mie-lendir.jpg'],
                        ['type' => 'text', 'content' => 'Mie Lendir'],
                        ['type' => 'text', 'content' => 'Kuliner Khas'],
                    ],
                    'Trilogi Pusat Perbelanjaan (Pasar Bawah)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-pasar-bawah.jpg'],
                        ['type' => 'text', 'content' => 'Pasar Bawah'],
                        ['type' => 'text', 'content' => 'Pusat Ekonomi'],
                    ],
                    'Trilogi Religi (Masjid Raya)' => [
                        ['type' => 'image', 'content' => 'pekanbaru-masjid-raya.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Raya'],
                        ['type' => 'text', 'content' => 'Pusat Ibadah'],
                    ],
                ],
            ],
            [
                'stage_number' => 20,
                'name' => 'Stage 20 - Banjarmasin',
                'city_name' => 'Banjarmasin',
                'region' => 'Kalimantan Selatan',
                'desc1' => 'Banjarmasin merupakan ibu kota Provinsi Kalimantan Selatan yang dikenal sebagai kota seribu sungai, dengan kehidupan masyarakat yang sangat erat dengan aliran sungai. Sungai Martapura dan Sungai Barito menjadi pusat aktivitas utama, sementara pasar terapung menjadi ikon khas yang mencerminkan tradisi perdagangan yang telah berlangsung sejak lama.',
                'desc2' => 'Selain itu, Banjarmasin memiliki kekayaan budaya yang kuat, terutama dari masyarakat Banjar yang masih menjaga tradisi dan nilai lokal. Kuliner khas seperti soto Banjar dan berbagai hidangan berbasis ikan turut memperkuat identitas kota ini, menjadikannya memiliki karakter unik melalui perpaduan budaya sungai, tradisi, dan aktivitas ekonomi.',
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
                'stage_number' => 21,
                'name' => 'Stage 21 - Palu',
                'city_name' => 'Palu',
                'region' => 'Sulawesi Tengah',
                'desc1' => 'Palu merupakan ibu kota Provinsi Sulawesi Tengah yang dikenal dengan kondisi geografis unik karena berada di wilayah lembah yang diapit pegunungan dan teluk, yaitu Teluk Palu. Kota ini berperan sebagai pusat pemerintahan, perdagangan, dan aktivitas ekonomi di wilayah Sulawesi Tengah, dengan perkembangan kota yang terus berlangsung.',
                'desc2' => 'Selain itu, Palu memiliki kekayaan budaya yang mencerminkan keberagaman masyarakatnya, termasuk tradisi lokal yang masih dijaga hingga kini. Keindahan alam seperti pantai, teluk, dan pegunungan di sekitarnya menjadi daya tarik tersendiri, menjadikan Palu memiliki karakter kuat melalui perpaduan alam, budaya, dan dinamika kehidupan masyarakat.',
                'map_pin_x' => 42,
                'map_pin_y' => 42,
                'trilogies' => [
                    'Lanskap Kota (Teluk Palu)' => [
                        ['type' => 'image', 'content' => 'teluk-palu.jpg'],
                        ['type' => 'text', 'content' => 'Teluk Palu'],
                        ['type' => 'text', 'content' => 'Lanskap Kota'],
                    ],
                    'Ikon Kota (Jembatan Palu)' => [
                        ['type' => 'image', 'content' => 'jembatan-palu.jpg'],
                        ['type' => 'text', 'content' => 'Jembatan Palu'],
                        ['type' => 'text', 'content' => 'Ikon Kota'],
                    ],
                    'Pantai Kota (Pantai Talise)' => [
                        ['type' => 'image', 'content' => 'pantai-talise.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Talise'],
                        ['type' => 'text', 'content' => 'Pantai Kota'],
                    ],
                    'Pegunungan (Gunung Gawalise)' => [
                        ['type' => 'image', 'content' => 'gunung-gawalise.jpg'],
                        ['type' => 'text', 'content' => 'Gawalise'],
                        ['type' => 'text', 'content' => 'Pegunungan'],
                    ],
                    'Taman Nasional (Lore Lindu)' => [
                        ['type' => 'image', 'content' => 'lore-lindu.jpg'],
                        ['type' => 'text', 'content' => 'Lore Lindu'],
                        ['type' => 'text', 'content' => 'Taman Nasional'],
                    ],
                    'Danau Besar (Danau Poso)' => [
                        ['type' => 'image', 'content' => 'danau-poso.jpg'],
                        ['type' => 'text', 'content' => 'Danau Poso'],
                        ['type' => 'text', 'content' => 'Danau Besar'],
                    ],
                    'Religi Kota (Masjid Darussalam)' => [
                        ['type' => 'image', 'content' => 'masjid-darussalam.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Darussalam'],
                        ['type' => 'text', 'content' => 'Religi Kota'],
                    ],
                    'Kuliner Tulang Sapi (Kaledo)' => [
                        ['type' => 'image', 'content' => 'kaledo.jpg'],
                        ['type' => 'text', 'content' => 'Kaledo'],
                        ['type' => 'text', 'content' => 'Tulang Sapi'],
                    ],
                    'Kuliner Pedas (Uta Dada)' => [
                        ['type' => 'image', 'content' => 'uta-dada.jpg'],
                        ['type' => 'text', 'content' => 'Uta Dada'],
                        ['type' => 'text', 'content' => 'Kuliner Pedas'],
                    ],
                ],
            ],
            [
                'stage_number' => 22,
                'name' => 'Stage 22 - Jayapura',
                'city_name' => 'Jayapura',
                'region' => 'Papua',
                'desc1' => 'Jayapura merupakan salah satu kota di Provinsi Papua yang berperan sebagai pusat pemerintahan, ekonomi, dan aktivitas utama di kawasan timur Indonesia. Kota ini memiliki letak geografis yang unik dengan perpaduan antara wilayah pesisir, perbukitan, dan teluk yang indah, menjadikan lanskapnya sangat khas. Teluk Youtefa serta Jembatan Youtefa menjadi ikon penting yang memperkuat identitas Jayapura sebagai kota dengan panorama alam yang menonjol.',
                'desc2' => 'Selain itu, Jayapura memiliki keberagaman budaya yang kuat dengan masyarakat yang terdiri dari berbagai suku asli Papua serta pendatang. Kehidupan sosial yang dinamis, tradisi yang masih terjaga, serta aktivitas perdagangan yang berkembang menjadikan kota ini terus tumbuh. Keindahan alam, kekayaan budaya, dan perkembangan kota yang berkelanjutan menjadikan Jayapura memiliki karakter yang kuat sebagai salah satu wilayah penting di Indonesia timur.',
                'map_pin_x' => 53,
                'map_pin_y' => 37,
                'trilogies' => [
                    'Danau Luas (Danau Sentani)' => [
                        ['type' => 'image', 'content' => 'danau-sentani.jpg'],
                        ['type' => 'text', 'content' => 'Danau Sentani'],
                        ['type' => 'text', 'content' => 'Danau Luas'],
                    ],
                    'Bukit Hijau (Bukit Teletubbies)' => [
                        ['type' => 'image', 'content' => 'bukit-teletubbies.jpg'],
                        ['type' => 'text', 'content' => 'Bukit Teletubbies'],
                        ['type' => 'text', 'content' => 'Bukit Hijau'],
                    ],
                    'Pantai Sejarah (Pantai Base-G)' => [
                        ['type' => 'image', 'content' => 'pantai-base-g.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Base-G'],
                        ['type' => 'text', 'content' => 'Pantai Sejarah'],
                    ],
                    'Ikon Kota (Jembatan Youtefa)' => [
                        ['type' => 'image', 'content' => 'jembatan-youtefa.jpg'],
                        ['type' => 'text', 'content' => 'Jembatan Youtefa'],
                        ['type' => 'text', 'content' => 'Ikon Kota'],
                    ],
                    'Sagu Khas (Papeda)' => [
                        ['type' => 'image', 'content' => 'papeda.jpg'],
                        ['type' => 'text', 'content' => 'Papeda'],
                        ['type' => 'text', 'content' => 'Sagu Khas'],
                    ],
                    'Sejarah Perang (Tugu MacArthur)' => [
                        ['type' => 'image', 'content' => 'tugu-mac-arthur.jpg'],
                        ['type' => 'text', 'content' => 'Tugu MacArthur'],
                        ['type' => 'text', 'content' => 'Sejarah Perang'],
                    ],
                ],
            ],
            [
                'stage_number' => 23,
                'name' => 'Stage 23 - Sorong',
                'city_name' => 'Sorong',
                'region' => 'Papua Barat Daya',
                'desc1' => 'Sorong merupakan salah satu kota di Provinsi Papua Barat Daya yang dikenal sebagai pusat ekonomi, industri, dan transportasi di kawasan barat Papua. Kota ini memiliki peran strategis sebagai pintu gerbang utama menuju berbagai destinasi di wilayah Papua, dengan aktivitas pelabuhan dan distribusi yang sangat penting bagi pergerakan barang dan manusia.',
                'desc2' => 'Selain itu, Sorong memiliki kedekatan dengan kawasan wisata dunia seperti Raja Ampat yang menjadikannya titik awal perjalanan wisata bahari. Keberagaman masyarakat, perkembangan kota yang pesat, serta kekayaan kuliner lokal turut memperkuat identitasnya, menjadikan Sorong memiliki karakter kuat melalui perpaduan aktivitas ekonomi, posisi strategis, dan akses menuju keindahan alam.',
                'map_pin_x' => 23,
                'map_pin_y' => 25,
                'trilogies' => [
                    'Pantai Pasir Putih (Pantai Tanjung Kasuari)' => [
                        ['type' => 'image', 'content' => 'pantai-tanjung-kasuari.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Tanjung Kasuari'],
                        ['type' => 'text', 'content' => 'Pantai Pasir Putih'],
                    ],
                    'Surga Laut (Raja Ampat)' => [
                        ['type' => 'image', 'content' => 'raja-ampat.jpg'],
                        ['type' => 'text', 'content' => 'Raja Ampat'],
                        ['type' => 'text', 'content' => 'Surga Laut'],
                    ],
                    'Hutan Mangrove (Mangrove Klawalu)' => [
                        ['type' => 'image', 'content' => 'klawalu.jpg'],
                        ['type' => 'text', 'content' => 'Mangrove Klawalu'],
                        ['type' => 'text', 'content' => 'Hutan Mangrove'],
                    ],
                    'Religi Kota (Masjid Raya Sorong)' => [
                        ['type' => 'image', 'content' => 'masjid-raya-sorong.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Raya'],
                        ['type' => 'text', 'content' => 'Religi Kota'],
                    ],
                    'Danau Jernih (Danau Ayamaru)' => [
                        ['type' => 'image', 'content' => 'danau-ayamaru.jpg'],
                        ['type' => 'text', 'content' => 'Danau Ayamaru'],
                        ['type' => 'text', 'content' => 'Danau Jernih'],
                    ],
                    'Pusat Niaga (Pasar Remu)' => [
                        ['type' => 'image', 'content' => 'pasar-remu.jpg'],
                        ['type' => 'text', 'content' => 'Pasar Remu'],
                        ['type' => 'text', 'content' => 'Pusat Niaga'],
                    ],
                    'Kuliner Laut (Ikan Bakar)' => [
                        ['type' => 'image', 'content' => 'ikan-bakar.jpg'],
                        ['type' => 'text', 'content' => 'Ikan Bakar'],
                        ['type' => 'text', 'content' => 'Kuliner Laut'],
                    ],
                ],
            ],
            [
                'stage_number' => 24,
                'name' => 'Stage 24 - Merauke',
                'city_name' => 'Merauke',
                'region' => 'Papua Selatan',
                'desc1' => 'Merauke merupakan salah satu kota di Provinsi Papua Selatan yang dikenal sebagai wilayah paling timur Indonesia dengan peran penting dalam konteks geografis dan nasional. Kota ini memiliki lanskap yang khas berupa dataran luas dan savana, berbeda dengan wilayah Papua lainnya, serta menjadi bagian dari identitas perbatasan Indonesia dengan Papua Nugini.',
                'desc2' => 'Selain itu, Merauke memiliki kekayaan budaya dari masyarakat lokal seperti suku Marind yang masih menjaga tradisi dan nilai adat. Aktivitas pertanian dan kehidupan masyarakat yang sederhana berpadu dengan kekayaan kuliner lokal, menjadikan Merauke memiliki karakter unik melalui perpaduan budaya, alam, dan posisinya sebagai wilayah timur Indonesia.',
                'map_pin_x' => 53,
                'map_pin_y' => 73,
                'trilogies' => [
                    'Savana Luas (Wasur)' => [
                        ['type' => 'image', 'content' => 'wasur.jpg'],
                        ['type' => 'text', 'content' => 'Wasur'],
                        ['type' => 'text', 'content' => 'Savana Luas'],
                    ],
                    'Ikon Nasional (Kapsul Waktu)' => [
                        ['type' => 'image', 'content' => 'kapsul-waktu.jpg'],
                        ['type' => 'text', 'content' => 'Kapsul Waktu'],
                        ['type' => 'text', 'content' => 'Ikon Nasional'],
                    ],
                    'Sungai Besar (Sungai Maro)' => [
                        ['type' => 'image', 'content' => 'sungai-maro.jpg'],
                        ['type' => 'text', 'content' => 'Sungai Maro'],
                        ['type' => 'text', 'content' => 'Sungai Besar'],
                    ],
                    'Simbol NKRI (Sabang Merauke)' => [
                        ['type' => 'image', 'content' => 'tugu-sabang-merauke.jpg'],
                        ['type' => 'text', 'content' => 'Sabang Merauke'],
                        ['type' => 'text', 'content' => 'Simbol NKRI'],
                    ],
                    'Pangan Lokal (Sagu)' => [
                        ['type' => 'image', 'content' => 'sagu.jpg'],
                        ['type' => 'text', 'content' => 'Sagu'],
                        ['type' => 'text', 'content' => 'Pangan Lokal'],
                    ],
                    'Kuliner Papua (Ikan Kuah Kuning)' => [
                        ['type' => 'image', 'content' => 'ikan-kuah-kuning.jpg'],
                        ['type' => 'text', 'content' => 'Ikan Kuah'],
                        ['type' => 'text', 'content' => 'Kuliner Papua'],
                    ],
                ],
            ],
            [
                'stage_number' => 25,
                'name' => 'Stage 25 - Palangka Raya',
                'city_name' => 'Palangka Raya',
                'region' => 'Kalimantan Tengah',
                'desc1' => 'Palangka Raya merupakan ibu kota Provinsi Kalimantan Tengah yang dikenal sebagai pusat pemerintahan dan perkembangan wilayah dengan tata kota yang luas dan terencana. Kota ini memiliki karakter khas dengan lingkungan yang masih didominasi hutan tropis serta Sungai Kahayan yang menjadi bagian penting dalam kehidupan masyarakat.',
                'desc2' => 'Selain itu, Palangka Raya mencerminkan kekayaan budaya masyarakat Dayak yang masih terjaga dalam tradisi dan kehidupan sehari-hari. Perpaduan antara alam, budaya lokal, dan perkembangan kota menjadikan Palangka Raya memiliki karakter yang unik sebagai wilayah yang terus berkembang di tengah lingkungan alami yang kuat.',
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
            [
                'stage_number' => 26,
                'name' => 'Stage 26 - Nusa Tenggara Barat',
                'city_name' => 'NTB',
                'region' => 'NTB',
                'desc1' => 'Nusa Tenggara Barat merupakan salah satu provinsi di Indonesia yang dikenal dengan kekayaan alam, budaya, dan pariwisatanya, dengan Pulau Lombok sebagai pusat daya tarik utama. Destinasi seperti Pantai Senggigi, Gili Trawangan, Pantai Selong Belanak, serta Gunung Rinjani mencerminkan keberagaman lanskap yang menjadikan Lombok representasi utama keindahan NTB di tingkat nasional dan internasional.',
                'desc2' => 'Di sisi budaya, tradisi masyarakat suku Sasak masih terjaga melalui desa adat seperti Desa Sade serta tradisi Peresean dan Festival Bau Nyale. NTB juga dikenal dengan identitas religius melalui Masjid Islamic Center di Mataram serta kuliner khas seperti Ayam Taliwang dan Sate Rembiga, menjadikannya wilayah dengan perpaduan kuat antara alam, budaya, dan cita rasa lokal.',
                'map_pin_x' => 30,
                'map_pin_y' => 50,
                'trilogies' => [
                    'Pantai Wisata (Pantai Senggigi)' => [
                        ['type' => 'image', 'content' => 'pantai-senggigi.jpg'],
                        ['type' => 'text', 'content' => 'Pantai Senggigi'],
                        ['type' => 'text', 'content' => 'Pantai Wisata'],
                    ],
                    'Pendakian Alam (Gunung Rinjani)' => [
                        ['type' => 'image', 'content' => 'gunung-rinjani.jpg'],
                        ['type' => 'text', 'content' => 'Gunung Rinjani'],
                        ['type' => 'text', 'content' => 'Pendakian Alam'],
                    ],
                    'Snorkeling (Gili Trawangan)' => [
                        ['type' => 'image', 'content' => 'gili-trawangan.jpg'],
                        ['type' => 'text', 'content' => 'Gili Trawangan'],
                        ['type' => 'text', 'content' => 'Snorkeling'],
                    ],
                    'Desa Adat Suku Sasak (Desa Sade)' => [
                        ['type' => 'image', 'content' => 'desa-sade.jpg'],
                        ['type' => 'text', 'content' => 'Desa Sade'],
                        ['type' => 'text', 'content' => 'Desa Adat Suku Sasak'],
                    ],
                    'Tradisi Duel (Peresean)' => [
                        ['type' => 'image', 'content' => 'peresean.jpg'],
                        ['type' => 'text', 'content' => 'Peresean'],
                        ['type' => 'text', 'content' => 'Tradisi Duel'],
                    ],
                    'Festival Laut (Bau Nyale)' => [
                        ['type' => 'image', 'content' => 'bau-nyale.jpg'],
                        ['type' => 'text', 'content' => 'Bau Nyale'],
                        ['type' => 'text', 'content' => 'Festival Laut'],
                    ],
                    'Ikon Mataram (Masjid Islamic Center)' => [
                        ['type' => 'image', 'content' => 'masjid-islamic-center.jpg'],
                        ['type' => 'text', 'content' => 'Masjid'],
                        ['type' => 'text', 'content' => 'Ikon Mataram'],
                    ],
                    'Bakar Pedas (Ayam Taliwang)' => [
                        ['type' => 'image', 'content' => 'ayam-taliwang.jpg'],
                        ['type' => 'text', 'content' => 'Ayam Taliwang'],
                        ['type' => 'text', 'content' => 'Bakar Pedas'],
                    ],
                    'Pedas Khas (Sate Rembiga)' => [
                        ['type' => 'image', 'content' => 'sate-rembiga.jpg'],
                        ['type' => 'text', 'content' => 'Sate Rembiga'],
                        ['type' => 'text', 'content' => 'Pedas Khas'],
                    ],
                ],
            ],
            [
                'stage_number' => 27,
                'name' => 'Stage 27 - Nusa Tenggara Timur',
                'city_name' => 'NTT',
                'region' => 'NTT',
                'desc1' => 'Nusa Tenggara Timur merupakan wilayah yang dikenal sebagai habitat komodo, dengan Taman Nasional Komodo sebagai pusat utama yang mencakup Pulau Komodo, Pulau Rinca, dan Pulau Padar, serta Labuan Bajo sebagai gerbang wisata. Keberadaan satwa purba ini berpadu dengan lanskap alam yang dramatis, menjadikan wilayah ini memiliki daya tarik global yang khas.',
                'desc2' => 'Selain itu, NTT memiliki keindahan alam beragam seperti Danau Kelimutu dengan tiga warna airnya dan bentang alam Flores yang eksotis. Tradisi masyarakat tetap terjaga melalui kampung adat seperti Wae Rebo dan tenun ikat yang sarat makna, menjadikan wilayah ini memiliki karakter kuat melalui perpaduan alam, budaya, dan ikon komodo yang mendunia.',
                'map_pin_x' => 48,
                'map_pin_y' => 50,
                'trilogies' => [
                    'Taman Nasional (Pulau Komodo)' => [
                        ['type' => 'image', 'content' => 'pulau-komodo.jpg'],
                        ['type' => 'text', 'content' => 'Pulau Komodo'],
                        ['type' => 'text', 'content' => 'Taman Nasional'],
                    ],
                    'Gerbang Wisata (Labuan Bajo)' => [
                        ['type' => 'image', 'content' => 'labuan-bajo.jpg'],
                        ['type' => 'text', 'content' => 'Labuan Bajo'],
                        ['type' => 'text', 'content' => 'Gerbang Wisata'],
                    ],
                    'Danau Tiga Warna (Danau Kelimutu)' => [
                        ['type' => 'image', 'content' => 'danau-kelimutu.jpg'],
                        ['type' => 'text', 'content' => 'Danau Kelimutu'],
                        ['type' => 'text', 'content' => 'Danau Tiga Warna'],
                    ],
                    'Desa Adat (Kampung Wae Rebo)' => [
                        ['type' => 'image', 'content' => 'kampung-wae-rebo.jpg'],
                        ['type' => 'text', 'content' => 'Kampung Wae Rebo'],
                        ['type' => 'text', 'content' => 'Desa Adat'],
                    ],
                    'Kain Khas (Tenun Ikat)' => [
                        ['type' => 'image', 'content' => 'tenun-ikat.jpg'],
                        ['type' => 'text', 'content' => 'Tenun Ikat'],
                        ['type' => 'text', 'content' => 'Kain Khas'],
                    ],
                    'Kuliner Khas (Se\'i)' => [
                        ['type' => 'image', 'content' => 'sei.jpg'],
                        ['type' => 'text', 'content' => 'Se\'i'],
                        ['type' => 'text', 'content' => 'Kuliner Khas'],
                    ],
                    'Budaya Lokal (Festival Komodo)' => [
                        ['type' => 'image', 'content' => 'festival-komodo.jpg'],
                        ['type' => 'text', 'content' => 'Festival Komodo'],
                        ['type' => 'text', 'content' => 'Budaya Lokal'],
                    ],
                ],
            ],
            [
                'stage_number' => 28,
                'name' => 'Stage 28 - Banda Aceh',
                'city_name' => 'Banda Aceh',
                'region' => 'Aceh',
                'desc1' => 'Banda Aceh merupakan ibu kota Provinsi Aceh yang dikenal sebagai pusat pemerintahan, pendidikan, dan kebudayaan di ujung barat Indonesia. Kota ini memiliki sejarah panjang sebagai wilayah penting dalam perdagangan dan penyebaran Islam, yang tercermin dari berbagai peninggalan sejarah serta kehidupan masyarakat yang religius dan berlandaskan nilai syariat.',
                'desc2' => 'Selain itu, Banda Aceh juga dikenal sebagai kota yang kuat dalam proses pemulihan dan pembangunan pasca bencana tsunami 2004, dengan berbagai monumen dan situs peringatan yang menjadi bagian dari identitasnya. Keberagaman budaya Aceh, arsitektur khas, serta kuliner tradisional seperti mie Aceh menjadikan kota ini memiliki karakter kuat melalui perpaduan sejarah, religi, dan ketahanan masyarakat.',
                'map_pin_x' => 30,
                'map_pin_y' => 15,
                'trilogies' => [
                    'Trilogi Masjid Ikonik (Masjid Raya Baiturrahman)' => [
                        ['type' => 'image', 'content' => 'masjid-baiturrahman.jpg'],
                        ['type' => 'text', 'content' => 'Masjid Raya Baiturrahman'],
                        ['type' => 'text', 'content' => 'Simbol Ketahanan Aceh'],
                    ],
                    'Trilogi Kapal Apung (PLTD Apung)' => [
                        ['type' => 'image', 'content' => 'pltd-apung.jpg'],
                        ['type' => 'text', 'content' => 'Kapal Apung'],
                        ['type' => 'text', 'content' => 'Monumen Tsunami'],
                    ],
                    'Trilogi Museum Tsunami (Museum Tsunami Aceh)' => [
                        ['type' => 'image', 'content' => 'museum-tsunami.jpg'],
                        ['type' => 'text', 'content' => 'Museum Tsunami'],
                        ['type' => 'text', 'content' => 'Peringatan Bencana'],
                    ],
                    'Trilogi Kuliner Khas (Mie Aceh)' => [
                        ['type' => 'image', 'content' => 'mie-aceh.jpg'],
                        ['type' => 'text', 'content' => 'Mie Aceh'],
                        ['type' => 'text', 'content' => 'Pedas Gurih'],
                    ],
                    'Trilogi Kopi Legendaris (Kopi Aceh)' => [
                        ['type' => 'image', 'content' => 'kopi-gayo.jpg'],
                        ['type' => 'text', 'content' => 'Kopi Aceh'],
                        ['type' => 'text', 'content' => 'Kopi Gayo'],
                    ],
                    'Trilogi Sejarah Perjuangan' => [
                        ['type' => 'image', 'content' => 'kerkhof.jpg'],
                        ['type' => 'text', 'content' => 'Kerkhof Peucut'],
                        ['type' => 'text', 'content' => 'Makam Pahlawan'],
                    ],
                ],
            ],
        ];
    }
}