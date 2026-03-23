# Gambar peta per pulau

Letakkan file gambar **siluet / peta** satu pulau di folder ini dengan nama:

| Pulau      | Nama file        |
|-----------|------------------|
| Sumatra   | `sumatra.png`    |
| Jawa      | `jawa.png`       |
| Bali      | `bali.png`       |
| Kalimantan| `kalimantan.png` |
| Sulawesi  | `sulawesi.png`   |
| Papua     | `papua.png`      |

Format yang didukung: **png**, **webp**, **jpg**, **jpeg**, atau **svg** (huruf kecil, ekstensi persis).

Setelah file ada, halaman **Pilih Stage** untuk pulau itu otomatis memakai gambarmu.  
Posisi kota di database: `map_pin_x` dan `map_pin_y` = **persen 0–100 dari kiri/atas file gambar** (kotak piksel gambar yang tampil di layar, termasuk margin putih di PNG), bukan dari kotak UI besar — supaya pin mengikuti siluet pulau.

Jika belum ada file, halaman memakai **siluet SVG bawaan** sebagai fallback.
