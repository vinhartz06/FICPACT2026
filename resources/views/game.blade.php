<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trilogi Nusantara - Pilih Pulau</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .batik-overlay {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5L35 20L50 20L38 30L43 45L30 37L17 45L22 30L10 20L25 20L30 5Z' fill='%23C1440E' fill-opacity='0.03'/%3E%3C/svg%3E");
        }

        .game-name {
            font-weight: 800;
            background: linear-gradient(135deg, #FFD700, #D4A017, #C1440E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;

            letter-spacing: -0.5px;
            line-height: 1;
            text-shadow: 0 2px 6px rgba(0,0,0,0.35);
        }

        .map-container {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            border: 3px solid rgba(212,160,23,0.35);
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }

        .island-label {
            position: absolute;
            padding: 8px 18px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;

            background: linear-gradient(135deg, #9f2f08, #C1440E, #D4A017);
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
            transition: all 0.25s ease;
        }

        .island-label:hover {
            transform: scale(1.12);
            background: linear-gradient(135deg, #1F7A8C, #C1440E);
        }

        @media (max-width: 768px) {
            .island-label {
                padding: 5px 10px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body class="min-h-screen relative">

    <!-- BACKGROUND -->
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/dashboard.jpg') }}"
             class="w-full h-full object-cover opacity-90">

        <div class="absolute inset-0 bg-gradient-to-br 
            from-[#C1440E]/10 
            via-[#D4A017]/5 
            to-[#1F7A8C]/10">
        </div>

        <div class="absolute inset-0 batik-overlay opacity-20"></div>
    </div>

    <!-- NAVBAR (UPDATED) -->
    <nav class="sticky top-0 z-50 px-6 py-4 flex items-center justify-between 
        bg-gradient-to-r from-[#FFD700]/80 via-[#D4A017]/80 to-[#C1440E]/80 
        backdrop-blur-sm shadow-md">

        <!-- Profile -->
        <a href="#" class="px-4 py-2 rounded-xl font-semibold text-sm
            bg-white/20 hover:bg-white/30 transition backdrop-blur-sm">
            👤
        </a>

        <!-- Title -->
        <h1 class="text-base md:text-lg font-bold text-black tracking-wide">
            Trilogi Nusantara
        </h1>

        <!-- Leaderboard -->
        <a href="#" class="px-4 py-2 rounded-xl text-black font-semibold text-sm
            bg-white/20 hover:bg-white/30 transition backdrop-blur-sm">
            🏆 Leaderboard
        </a>
    </nav>

    <!-- MAIN -->
    <main class="px-4 py-4">

        <div class="text-center mb-3">
            <h2 class="text-3xl md:text-4xl font-bold text-[#2E2E2E]">
                Pilih Pulau
            </h2>
            <p class="text-[#2E2E2E]/80 text-sm md:text-base">
                Mulai perjalanan menjelajahi Nusantara
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <div class="map-container">

                <img src="{{ asset('images/indonesia-map.jpg') }}"
                     class="w-full opacity-80">

                <a href="#" class="island-label" style="top: 30%; left: 10%;">Sumatra</a>
                <a href="#" class="island-label" style="top: 75%; left: 32%;">Jawa</a>
                <a href="#" class="island-label" style="top: 78%; left: 50%;">Bali</a>
                <a href="#" class="island-label" style="top: 35%; left: 35%;">Kalimantan</a>
                <a href="#" class="island-label" style="top: 45%; left: 52%;">Sulawesi</a>
                <a href="#" class="island-label" style="top: 55%; left: 85%;">Papua</a>

            </div>
        </div>

    </main>

</body>
</html>