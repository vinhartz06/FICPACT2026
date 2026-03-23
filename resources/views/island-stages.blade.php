<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Pilih Stage · {{ $islandTitle }} - Trilogi Nusantara</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,600;14..32,800&display=swap" rel="stylesheet">
    <style>
        .island-map-stage {
            position: relative;
            width: 100%;
            max-height: min(86vh, 860px);
            min-height: 220px;
            aspect-ratio: 2 / 1;
            border-radius: 1.25rem;
            overflow: hidden;
            background: linear-gradient(160deg, rgba(30, 42, 42, 0.5) 0%, rgba(45, 35, 28, 0.65) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }
        .island-map-stage .map-layer {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .island-map-stage .map-layer img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            transform: scale(1.08);
            transform-origin: center center;
            filter: drop-shadow(0 8px 24px rgba(0, 0, 0, 0.45));
        }
        .island-map-stage .map-layer.is-fallback {
            background: radial-gradient(ellipse at 50% 45%, rgba(252, 230, 196, 0.12) 0%, transparent 55%),
                        linear-gradient(180deg, #2a2420 0%, #1a1816 100%);
            color: #FCE6C4;
        }
        .stage-pin {
            position: absolute;
            transform: translate(-50%, -50%);
            z-index: 5;
            visibility: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.1rem;
            text-decoration: none;
            transition: transform 0.2s ease, filter 0.2s ease;
        }
        .stage-pin:hover:not(.is-locked) {
            transform: translate(-50%, -50%) scale(1.05);
            filter: brightness(1.08);
        }
        .stage-pin .pin-dot {
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 9999px;
            background: linear-gradient(145deg, #F7D98C, #CF9F4A);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 2px rgba(230, 181, 103, 0.4), 0 2px 6px rgba(0, 0, 0, 0.35);
            animation: pin-pulse 2.4s ease-in-out infinite;
        }
        .stage-pin.is-locked .pin-dot {
            background: #5c5c5c;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.25);
            animation: none;
        }
        @keyframes pin-pulse {
            0%, 100% { box-shadow: 0 0 0 2px rgba(230, 181, 103, 0.4), 0 2px 6px rgba(0, 0, 0, 0.35); }
            50% { box-shadow: 0 0 0 5px rgba(230, 181, 103, 0.12), 0 2px 6px rgba(0, 0, 0, 0.35); }
        }
        .stage-pin .pin-label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            color: #1a1512;
            background: rgba(252, 230, 196, 0.95);
            padding: 0.1rem 0.35rem;
            border-radius: 9999px;
            border: 1px solid rgba(207, 159, 74, 0.45);
            white-space: nowrap;
            max-width: min(36vw, 120px);
            overflow: hidden;
            text-overflow: ellipsis;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.18);
            line-height: 1.2;
        }
        .stage-pin.is-locked .pin-label {
            background: rgba(80, 80, 80, 0.9);
            color: #e0e0e0;
            border-color: rgba(255, 255, 255, 0.15);
        }
        @media (min-width: 640px) {
            .stage-pin .pin-dot { width: 0.65rem; height: 0.65rem; }
            .stage-pin .pin-label { font-size: 0.65rem; padding: 0.12rem 0.4rem; }
        }
    </style>
</head>
<body class="min-h-dvh bg-gradient-to-br from-[#1E2A2A] via-[#2F2A24] to-[#4A2F1D] text-[#FCE6C4] flex flex-col">

    <!-- NAVBAR: below 1000px -> emoji only, no Trilogi Nusantara text -->
    <nav class="relative shrink-0 w-full px-3 sm:px-6 py-2 sm:py-3 flex items-center justify-between
                backdrop-blur-md bg-black/20 border-b border-white/10 min-h-[3rem] sm:min-h-[3.25rem]">
        
        <!-- Left buttons: emoji only on mobile, emoji + text above 1000px -->
        <div class="flex items-center gap-1 sm:gap-2 shrink-0 relative z-10 flex-wrap">
            <a href="{{ url('/') }}" title="Beranda"
               class="group flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 rounded-xl sm:rounded-2xl bg-white/5 hover:bg-white/20 transition-all backdrop-blur-sm border border-white/10">
                <span class="text-sm sm:text-xl" aria-hidden="true">🏠</span>
                <span class="text-xs sm:text-sm font-medium text-[#F2E0C9] ml-1 hidden" style="display: none;">Beranda</span>
            </a>
            <a href="{{ route('game') }}" title="Kembali ke peta pulau"
               class="group flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 rounded-xl sm:rounded-2xl bg-white/5 hover:bg-white/20 transition-all backdrop-blur-sm border border-white/10">
                <span class="text-xs sm:text-base" aria-hidden="true">🗺</span>
                <span class="text-xs sm:text-sm font-medium text-[#F2E0C9] ml-1 hidden" style="display: none;">Peta</span>
            </a>
            <button type="button" id="nav-logout" title="Keluar"
                    class="group flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 rounded-xl sm:rounded-2xl bg-white/5 hover:bg-red-500/25 hover:border-red-400/40 transition-all backdrop-blur-sm border border-white/10 cursor-pointer">
                <span class="text-xs sm:text-lg" aria-hidden="true">🚪</span>
                <span class="text-xs sm:text-sm font-medium text-[#F2E0C9] ml-1 hidden" style="display: none;">Keluar</span>
            </button>
        </div>

        <!-- Game Title: hidden below 1000px, visible above -->
        <h1 class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-0
                   text-center text-sm sm:text-xl md:text-2xl font-extrabold tracking-tight px-2
                   max-w-[calc(100vw-10rem)] sm:max-w-[calc(100vw-14rem)] md:max-w-none leading-tight
                   bg-gradient-to-r from-[#F7D98C] via-[#E6B567] to-[#CF9F4A] bg-clip-text text-transparent drop-shadow-md"
            style="display: none;">
            Trilogi Nusantara
        </h1>

        <!-- Empty spacer (no leaderboard on this page) -->
        <div class="w-8 sm:w-10 md:w-16 shrink-0 relative z-10" aria-hidden="true"></div>
    </nav>

    <main class="flex-1 flex flex-col px-4 sm:px-6 py-4 sm:py-6 min-h-0 overflow-y-auto">
        <header class="text-center shrink-0 mb-3">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-black mb-0.5 bg-gradient-to-r from-[#FBE6B0] to-[#E2B670] bg-clip-text text-transparent">
                Pilih Stage — {{ $islandTitle }}
            </h2>
            <p class="text-amber-100/70 text-xs sm:text-sm max-w-xl mx-auto">
                @if ($stages->isEmpty())
                    Peta pulau di bawah; stage/kota akan muncul di sini setelah ditambahkan ke database.
                @else
                    Ketuk titik di peta untuk memasuki stage kota tersebut.
                @endif
                @if(!$islandMapUrl)
                    <span class="block mt-1 text-amber-200/50 text-xs">Tip: letakkan gambar PNG pulau di <code class="text-amber-200/80">public/images/islands/{{ $islandSlug }}.png</code></span>
                @endif
            </p>
        </header>

        {{-- Peta selalu tampil --}}
        <div class="w-full max-w-6xl mx-auto flex-1 flex flex-col min-h-0">
            <div class="island-map-stage mx-auto w-full" id="island-map" role="img" aria-label="Peta {{ $islandTitle }}">
                <div class="map-layer {{ $islandMapUrl ? '' : 'is-fallback' }}">
                    @if ($islandMapUrl)
                        <img src="{{ $islandMapUrl }}"
                             alt="Siluet {{ $islandTitle }}"
                             loading="lazy"
                             decoding="async">
                    @else
                        @include('partials.island-map-fallback', ['islandSlug' => $islandSlug])
                    @endif
                </div>

                @foreach ($stagesWithPins as $item)
                    @php
                        /** @var \App\Models\Stage $s */
                        $s = $item['stage'];
                    @endphp
                    <a href="{{ url('/play') }}?stage={{ $s->id }}"
                       class="stage-pin stage-row"
                       data-pin-x="{{ $item['x'] }}"
                       data-pin-y="{{ $item['y'] }}"
                       data-stage-number="{{ $s->stage_number }}"
                       data-stage-id="{{ $s->id }}"
                       title="{{ $s->city_name }} — {{ $s->region }}">
                        <span class="pin-dot" aria-hidden="true"></span>
                        <span class="pin-label">{{ $s->city_name }}</span>
                    </a>
                @endforeach
            </div>

            @if ($stages->isEmpty())
                <p class="text-center text-amber-200/90 rounded-2xl border border-amber-400/25 bg-black/25 backdrop-blur-sm p-5 max-w-md mx-auto mt-4 text-sm">
                    Belum ada stage untuk pulau ini. Tunggu update selanjutnya!
                </p>
            @else
                <p class="text-center text-xs text-amber-200/40 mt-4 shrink-0">Atau pilih dari daftar:</p>
                <ul class="mt-2 space-y-2 max-w-lg mx-auto w-full pb-6 shrink-0" id="stage-list-fallback" aria-label="Daftar stage">
                    @foreach ($stages as $s)
                        <li class="flex items-center gap-2">
                            <a href="{{ url('/play') }}?stage={{ $s->id }}"
                               class="stage-row flex-1 flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 px-4 py-3 transition-all text-sm"
                               data-stage-number="{{ $s->stage_number }}"
                               data-stage-id="{{ $s->id }}">
                                <div>
                                    <div class="font-bold text-[#F7D98C]">{{ $s->city_name }}</div>
                                    <div class="text-xs text-amber-100/60">{{ $s->region }} · Stage {{ $s->stage_number }}</div>
                                </div>
                                <span class="text-lg" aria-hidden="true">▶</span>
                            </a>
                            <button type="button"
                                    class="info-button shrink-0 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center transition-colors"
                                    data-city-name="{{ $s->city_name }}"
                                    data-city-desc1="{{ $s->desc1 ?? '' }}"
                                    data-city-desc2="{{ $s->desc2 ?? '' }}"
                                    aria-label="Informasi {{ $s->city_name }}">
                                <span class="text-sm text-amber-200/80 font-serif italic">i</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>

    {{-- Modal for city information --}}
    <div id="info-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm transition-all duration-200" style="display: none;">
        <div class="bg-gradient-to-br from-[#2A241F] to-[#1F1B18] rounded-2xl max-w-md w-full border border-white/20 shadow-2xl overflow-hidden animate-fade-in-up">
            <div class="flex justify-between items-center border-b border-white/10 px-5 py-3 bg-black/20">
                <h3 id="modal-city-name" class="text-lg sm:text-xl font-bold text-[#F7D98C]">Kota</h3>
                <button id="modal-close-btn" class="text-amber-200/70 hover:text-white text-2xl leading-none transition">&times;</button>
            </div>
            <div class="p-5 space-y-3 text-[#FCE6C4]">
                <p id="modal-desc1" class="text-sm leading-relaxed text-amber-100/90"></p>
                <p id="modal-desc2" class="text-sm leading-relaxed text-amber-100/80 pt-1"></p>
            </div>
        </div>
    </div>

    <script>
        (function() {
            // Modal elements
            const modal = document.getElementById('info-modal');
            const modalCityName = document.getElementById('modal-city-name');
            const modalDesc1 = document.getElementById('modal-desc1');
            const modalDesc2 = document.getElementById('modal-desc2');
            const modalCloseBtn = document.getElementById('modal-close-btn');

            function openModal(cityName, desc1, desc2) {
                modalCityName.textContent = cityName;
                modalDesc1.textContent = desc1 && desc1.trim() !== '' ? desc1 : 'Informasi belum tersedia.';
                modalDesc2.textContent = desc2 && desc2.trim() !== '' ? desc2 : '';
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', closeModal);
            }

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            const infoButtons = document.querySelectorAll('.info-button');
            infoButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const cityName = this.getAttribute('data-city-name') || 'Kota';
                    const desc1 = this.getAttribute('data-city-desc1') || '';
                    const desc2 = this.getAttribute('data-city-desc2') || '';
                    openModal(cityName, desc1, desc2);
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
                    closeModal();
                }
            });
        })();
    </script>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.2s ease-out forwards;
        }

        /* BELOW 1000px: hide Trilogi Nusantara title, buttons emoji only */
        @media (max-width: 1000px) {
            nav h1 {
                display: none !important;
            }
            /* Ensure text labels are hidden */
            nav .group span:not([aria-hidden="true"]) {
                display: none !important;
            }
        }

        /* ABOVE 1000px: show Trilogi Nusantara title and button text */
        @media (min-width: 1001px) {
            nav h1 {
                display: block !important;
            }
            nav .group span:not([aria-hidden="true"]) {
                display: inline-block !important;
            }
        }
    </style>

    <script>window.TRILOGI_HOME_URL = @json(url('/'));</script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/island-stages.js') }}"></script>
</body>
</html>