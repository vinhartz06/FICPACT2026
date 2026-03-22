<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Trilogi Nusantara · Pilih Pulau</title>

    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <style>
        /* batik texture overlay (subtle) */
        .batik-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='70' height='70' viewBox='0 0 70 70' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M35 7L41 24L58 24L46 36L52 53L35 43L18 53L24 36L12 24L29 24L35 7Z' fill='%23D9C5A7' fill-opacity='0.1'/%3E%3C/svg%3E");
        }

        /* island labels — natural, warm, subtle shadow */
        .island-label {
            position: absolute;
            padding: 8px 20px;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.01em;
            backdrop-filter: blur(6px);
            background: rgba(30, 25, 22, 0.75);
            color: #FCE6C4;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(235, 185, 110, 0.4);
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            border: none;
        }

        .island-label:hover {
            transform: scale(1.08);
            background: rgba(45, 35, 28, 0.9);
            color: #FFE2B5;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 0 0 2px #E2B87A;
        }

        @media (max-width: 768px) {
            .island-label {
                padding: 5px 12px;
                font-size: 0.7rem;
                backdrop-filter: blur(4px);
            }
        }

        /* no scroll on desktop */
        body {
            overflow: hidden;
            height: 100dvh;
        }
    </style>
</head>
<body class="flex flex-col h-dvh">

    <!-- BACKGROUND: rich gradient + image overlay with low opacity -->
    <div class="fixed inset-0 -z-10">
        <!-- main gradient: deep earthy to warm umber -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#1E2A2A] via-[#2F2A24] to-[#4A2F1D]"></div>
        <!-- background image with low opacity (0.25) layered on top -->
        <div class="absolute inset-0 bg-[url('{{ asset('images/dashboard.jpg') }}')] bg-cover bg-center opacity-90 mix-blend-overlay"></div>
        <!-- subtle batik pattern -->
        <div class="absolute inset-0 batik-overlay opacity-30 mix-blend-soft-light"></div>
        <!-- extra vignette for depth -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
    </div>

    <!-- NAVBAR — judul benar-benar di tengah viewport (absolute), sisi kiri/kanan z-10 -->
    <nav class="relative shrink-0 w-full px-4 sm:px-6 py-3 flex items-center justify-between 
                backdrop-blur-md bg-black/20 border-b border-white/10
                transition-all duration-300 min-h-[3.25rem]">
        
        <!-- Kembali ke landing + Profil + Keluar -->
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0 relative z-10 max-w-[42%] sm:max-w-none">
            <a href="{{ url('/') }}" title="Kembali ke halaman utama"
               class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl 
                      bg-white/5 hover:bg-white/20 transition-all 
                      backdrop-blur-sm border border-white/10">
                <span class="text-lg sm:text-xl drop-shadow-sm" aria-hidden="true">🏠</span>
                <span class="hidden sm:inline text-sm font-medium text-[#F2E0C9]">Beranda</span>
            </a>
            <a href="#" id="nav-profil" class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl 
                              bg-white/5 hover:bg-white/20 transition-all 
                              backdrop-blur-sm border border-white/10">
                <span class="text-lg sm:text-xl drop-shadow-sm">👤</span>
                <span class="hidden md:inline text-sm font-medium text-[#F2E0C9]">Profil</span>
            </a>
            <button type="button" id="nav-logout" title="Keluar dari akun / kembali ke beranda"
                    class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl 
                           bg-white/5 hover:bg-red-500/25 hover:border-red-400/40 transition-all 
                           backdrop-blur-sm border border-white/10 cursor-pointer">
                <span class="text-base sm:text-lg drop-shadow-sm" aria-hidden="true">🚪</span>
                <span class="hidden md:inline text-sm font-medium text-[#F2E0C9]">Keluar</span>
            </button>
        </div>

        <!-- Game Title — tepat di tengah layar -->
        <h1 class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-0
                   text-center text-base sm:text-xl md:text-2xl font-extrabold tracking-tight px-2
                   max-w-[calc(100vw-9.5rem)] sm:max-w-[calc(100vw-12rem)] md:max-w-none leading-tight
                   bg-gradient-to-r from-[#F7D98C] via-[#E6B567] to-[#CF9F4A]
                   bg-clip-text text-transparent drop-shadow-md">
            Trilogi Nusantara
        </h1>

        <!-- Leaderboard -->
        <a href="#" id="nav-leaderboard" class="group flex items-center gap-2 px-2.5 sm:px-3 py-2 rounded-2xl shrink-0 relative z-10
                          bg-white/5 hover:bg-white/20 transition-all 
                          backdrop-blur-sm border border-white/10">
            <span class="text-base drop-shadow">🏆</span>
            <span class="hidden sm:inline text-sm font-medium text-[#F2E0C9]">Leaderboard</span>
        </a>
    </nav>

    <!-- MAIN CONTENT — flex, no scroll on desktop -->
    <main class="flex-1 min-h-0 flex flex-col px-5 md:px-6 py-2 md:py-3 overflow-hidden">
        
        <!-- title section with refined colors -->
        <div class="shrink-0 text-center mb-3 md:mb-4">
            <h2 class="text-3xl md:text-5xl font-black tracking-wide 
                       bg-gradient-to-r from-[#FBE6B0] to-[#E2B670] 
                       bg-clip-text text-transparent drop-shadow-sm">
                Pilih Pulau
            </h2>
            <p class="text-amber-100/80 text-sm md:text-base font-medium mt-1 
                      flex items-center justify-center gap-1">
                <span class="inline-block w-5 h-px bg-amber-300/50"></span>
                petualangan menjelajahi nusantara dimulai sekarang
                <span class="inline-block w-5 h-px bg-amber-300/50"></span>
            </p>
        </div>

        <!-- MAP: kotak terang + peta lebih besar agar siluet hitam kontras -->
        <div class="flex-1 min-h-0 flex items-center justify-center w-full px-1 sm:px-3">
            <div class="island-map-card w-full max-w-[min(92vw,900px)] rounded-2xl border-2 border-[#d4a017]/35
                        bg-[#faf6ef]/[0.68] backdrop-blur-lg shadow-[0_16px_40px_rgba(0,0,0,0.32)]
                        p-2 sm:p-3 md:p-4 flex items-center justify-center">
                <div class="relative inline-block max-w-full mx-auto">
                <img src="{{ asset('images/indonesia-map.png') }}"
                     class="indonesia-map-img block w-auto max-w-full h-auto object-contain rounded-xl
                            drop-shadow-md"
                     alt="Peta Nusantara"
                     style="pointer-events: auto;">
                
                <!-- island labels (relative to image) -->
                <a href="#" class="island-label" data-island="sumatra" style="top: 29%; left: 9%;">⚡ Sumatra</a>
                <a href="#" class="island-label" data-island="jawa" style="top: 73%; left: 31%;">🌾 Jawa</a>
                <a href="#" class="island-label" data-island="bali" style="top: 76%; left: 48%;">🌺 Bali</a>
                <a href="#" class="island-label" data-island="kalimantan" style="top: 34%; left: 34%;">🌿 Kalimantan</a>
                <a href="#" class="island-label" data-island="sulawesi" style="top: 44%; left: 51%;">⛰️ Sulawesi</a>
                <a href="#" class="island-label" data-island="papua" style="top: 53%; left: 83%;">🦜 Papua</a>
                </div>
            </div>
        </div>

        <!-- subtle decorative footer -->
        <div class="shrink-0 flex justify-center gap-3 mt-2 text-amber-200/40 text-xs font-medium">
            {{-- <span>✦ warisan budaya ✦</span>
            <span class="hidden sm:inline">•</span>
            <span class="hidden sm:inline">jelajahi nusantara</span>
            <span class="hidden sm:inline">•</span> --}}
            <span>© 2026 Trilogi Nusantara</span>
        </div>
    </main>

    <!-- responsive adjustments for perfect fit -->
    <style>
        /* desktop: no scroll, image scaling perfect */
        @media (min-width: 1024px) {
            body {
                overflow: hidden;
            }
            main {
                overflow-y: visible;
            }
            .island-label {
                font-size: 0.85rem;
                padding: 7px 18px;
                white-space: nowrap;
            }
            .indonesia-map-img {
                max-height: min(70vh, 680px);
                min-height: 260px;
                width: auto;
            }
        }
        
        /* tablet and mobile: allow gentle scroll if needed but keep body clean */
        @media (max-width: 1023px) {
            .indonesia-map-img {
                max-height: min(58vh, 520px);
                min-height: 200px;
                width: auto;
            }
            .island-label {
                padding: 4px 10px;
                font-size: 0.65rem;
            }
            main {
                overflow-y: auto;
            }
            body {
                overflow-y: auto;
            }
        }

        /* large screens adjustment */
        @media (min-width: 1600px) {
            .indonesia-map-img {
                max-height: min(72vh, 760px);
            }
        }
        
        /* responsive label position tweaks for smaller devices */
        @media (max-width: 768px) {
            a.island-label[style*="top: 29%"] { top: 28% !important; left: 7% !important; }
            a.island-label[style*="top: 73%"] { top: 72% !important; left: 29% !important; }
            a.island-label[style*="top: 76%"] { top: 75% !important; left: 46% !important; }
            a.island-label[style*="top: 34%"] { top: 33% !important; left: 32% !important; }
            a.island-label[style*="top: 44%"] { top: 43% !important; left: 49% !important; }
            a.island-label[style*="top: 53%"] { top: 52% !important; left: 80% !important; }
        }
    </style>
    <script>window.TRILOGI_HOME_URL = @json(url('/'));</script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/game-dashboard.js') }}"></script>
</body>
</html>