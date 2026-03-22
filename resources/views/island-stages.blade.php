<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Pilih Stage · {{ $islandTitle }} · Trilogi Nusantara</title>
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
        /* Pin pakai % relatif #island-map; JS isi dari kotak gambar ter-render (bukan area kosong letterbox) */
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

    <nav class="relative shrink-0 w-full px-4 sm:px-6 py-3 flex items-center justify-between
                backdrop-blur-md bg-black/20 border-b border-white/10 min-h-[3.25rem]">
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0 relative z-10 max-w-[46%] sm:max-w-none flex-wrap">
            <a href="{{ url('/') }}" title="Beranda"
               class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl bg-white/5 hover:bg-white/20 transition-all backdrop-blur-sm border border-white/10">
                <span class="text-lg sm:text-xl" aria-hidden="true">🏠</span>
                <span class="hidden sm:inline text-sm font-medium text-[#F2E0C9]">Beranda</span>
            </a>
            <a href="{{ route('game') }}" title="Kembali ke peta pulau"
               class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl bg-white/5 hover:bg-white/20 transition-all backdrop-blur-sm border border-white/10">
                <span class="text-sm sm:text-base" aria-hidden="true">🗺</span>
                <span class="hidden md:inline text-sm font-medium text-[#F2E0C9]">Peta</span>
            </a>
            <button type="button" id="nav-logout" title="Keluar"
                    class="group flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-2 rounded-2xl bg-white/5 hover:bg-red-500/25 hover:border-red-400/40 transition-all backdrop-blur-sm border border-white/10 cursor-pointer">
                <span class="text-base sm:text-lg" aria-hidden="true">🚪</span>
                <span class="hidden md:inline text-sm font-medium text-[#F2E0C9]">Keluar</span>
            </button>
        </div>

        <h1 class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-0
                   text-center text-base sm:text-xl md:text-2xl font-extrabold tracking-tight px-2
                   max-w-[calc(100vw-10rem)] sm:max-w-[calc(100vw-14rem)] md:max-w-none leading-tight
                   bg-gradient-to-r from-[#F7D98C] via-[#E6B567] to-[#CF9F4A] bg-clip-text text-transparent drop-shadow-md">
            Trilogi Nusantara
        </h1>

        <div class="w-10 sm:w-16 md:w-24 shrink-0 relative z-10" aria-hidden="true"></div>
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

        {{-- Peta selalu tampil (seperti Jawa); pesan kosong hanya jika belum ada stage di DB --}}
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
                        <li>
                            <a href="{{ url('/play') }}?stage={{ $s->id }}"
                               class="stage-row flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 px-4 py-3 transition-all text-sm"
                               data-stage-number="{{ $s->stage_number }}"
                               data-stage-id="{{ $s->id }}">
                                <div>
                                    <div class="font-bold text-[#F7D98C]">{{ $s->city_name }}</div>
                                    <div class="text-xs text-amber-100/60">{{ $s->region }} · Stage {{ $s->stage_number }}</div>
                                </div>
                                <span class="text-lg" aria-hidden="true">▶</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>

    <script>window.TRILOGI_HOME_URL = @json(url('/'));</script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/island-stages.js') }}"></script>
</body>
</html>
