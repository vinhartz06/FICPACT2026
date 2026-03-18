<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trilogi Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(2deg); }
        }

        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(-2deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(193, 68, 14, 0.4), 0 0 40px rgba(212, 160, 23, 0.2); }
            50% { box-shadow: 0 0 40px rgba(193, 68, 14, 0.8), 0 0 80px rgba(212, 160, 23, 0.4); }
        }

        @keyframes glow-move {
            0% { transform: translate(0, 0); }
            25% { transform: translate(20px, -20px); }
            50% { transform: translate(0, -40px); }
            75% { transform: translate(-20px, -20px); }
            100% { transform: translate(0, 0); }
        }

        @keyframes blob-drift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(60px, 0) scale(0.95); }
            75% { transform: translate(30px, 30px) scale(1.05); }
        }

        @keyframes card-flip {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(180deg); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes bounce-icon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes parallax-bg {
            0% { transform: translateY(0px); }
            100% { transform: translateY(50px); }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: #0a0e27;
            color: #1a1a1a;
        }

        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('{{ asset("images/indonesia.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.2;
            z-index: 1;
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(193, 68, 14, 0.02) 10px, rgba(193, 68, 14, 0.02) 20px);
            z-index: 2;
        }

        .floating-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.3;
            z-index: 0;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #C1440E, #D4A017);
            top: -100px;
            left: -100px;
            animation: blob-drift 20s ease-in-out infinite;
        }

        .blob-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #1F7A8C, #1a5f7a);
            bottom: -50px;
            right: -50px;
            animation: blob-drift 15s ease-in-out infinite reverse;
        }

        .blob-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #D4A017, #C1440E);
            top: 50%;
            right: 10%;
            animation: blob-drift 25s ease-in-out infinite;
        }

        .glow-dot {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: radial-gradient(circle, #D4A017, #C1440E);
            box-shadow: 0 0 20px rgba(212, 160, 23, 0.8);
            animation: glow-move 8s ease-in-out infinite;
            z-index: 3;
        }

        .glow-dot:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .glow-dot:nth-child(2) { top: 60%; right: 15%; animation-delay: 2s; }
        .glow-dot:nth-child(3) { bottom: 20%; left: 20%; animation-delay: 4s; }
        .glow-dot:nth-child(4) { top: 40%; right: 5%; animation-delay: 6s; }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 800px;
            padding: 0 20px;
            animation: fadeInUp 1s ease-out;
        }

        .hero-title {
            font-size: clamp(3rem, 10vw, 7rem);
            font-weight: 900;
            background: linear-gradient(135deg, #FFD700, #FFA500, #FF6B6B, #D4A017);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(212, 160, 23, 0.3);
            letter-spacing: -2px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 4vw, 1.5rem);
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 40px;
            font-weight: 300;
            letter-spacing: 0.5px;
            animation: fadeInUp 1.2s ease-out;
        }

        .hero-cta {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1.4s ease-out;
        }

        .btn {
            padding: 14px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-play {
            background: linear-gradient(135deg, #C1440E, #FF6B35);
            color: white;
            box-shadow: 0 0 30px rgba(193, 68, 14, 0.5);
        }

        .btn-play:hover {
            transform: scale(1.08);
            box-shadow: 0 0 60px rgba(193, 68, 14, 0.8), 0 10px 30px rgba(193, 68, 14, 0.4);
        }

        .btn-play:active {
            transform: scale(0.98);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #FFD700;
            border: 2px solid #D4A017;
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(212, 160, 23, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 160, 23, 0.3);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: float 3s ease-in-out infinite;
        }

        .scroll-indicator svg {
            width: 30px;
            height: 30px;
            stroke: rgba(212, 160, 23, 0.6);
            fill: none;
            stroke-width: 2;
        }

        .preview-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(180deg, #0f3460 0%, #1a1a2e 100%);
            overflow: hidden;
        }

        .preview-bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(193, 68, 14, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            filter: blur(60px);
            z-index: 0;
        }

        .preview-container {
            max-width: 900px;
            width: 100%;
            position: relative;
            z-index: 5;
        }

        .preview-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #FFD700;
            text-align: center;
            margin-bottom: 60px;
            text-shadow: 0 0 20px rgba(212, 160, 23, 0.3);
        }

        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
            perspective: 1000px;
        }

        .game-card {
            aspect-ratio: 1;
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.2), rgba(193, 68, 14, 0.2));
            border: 2px solid rgba(212, 160, 23, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            animation: float 6s ease-in-out infinite;
            flex-direction: column;
            gap: 8px;
        }

        .game-card.text-card {
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.15), rgba(193, 68, 14, 0.15));
            padding: 12px;
        }

        .game-card.image-card {
            background: linear-gradient(135deg, rgba(31, 122, 140, 0.15), rgba(193, 68, 14, 0.15));
            padding: 0;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .card-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-weight: 600;
            word-break: break-word;
            line-height: 1.2;
        }

        .game-card:nth-child(odd) {
            animation-delay: 0.5s;
        }

        .game-card:hover {
            transform: rotateY(15deg) translateZ(20px) scale(1.05);
            box-shadow: 0 10px 40px rgba(212, 160, 23, 0.4), inset 0 0 20px rgba(212, 160, 23, 0.1);
            border-color: rgba(212, 160, 23, 0.6);
        }

        .game-card.matched {
            background: linear-gradient(135deg, rgba(31, 122, 140, 0.4), rgba(193, 68, 14, 0.3));
            box-shadow: 0 0 30px rgba(31, 122, 140, 0.5);
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .game-card:hover::before {
            left: 100%;
        }

        .features-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }

        .features-grid {
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            position: relative;
            z-index: 5;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 160, 23, 0.2);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.1), rgba(193, 68, 14, 0.05));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            border-color: rgba(212, 160, 23, 0.5);
            box-shadow: 0 20px 50px rgba(193, 68, 14, 0.2), 0 0 30px rgba(212, 160, 23, 0.1);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            animation: bounce-icon 2s ease-in-out infinite;
        }

        .feature-card:nth-child(2) .feature-icon {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(3) .feature-icon {
            animation-delay: 0.4s;
        }

        .feature-card:nth-child(4) .feature-icon {
            animation-delay: 0.6s;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #FFD700;
            margin-bottom: 15px;
        }

        .feature-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            line-height: 1.6;
        }

        .islands-section {
            position: relative;
            min-height: 120vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(180deg, #0f3460 0%, #1a1a2e 100%);
        }

        .islands-container {
            max-width: 1400px;
            width: 100%;
            position: relative;
            z-index: 5;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #FFD700;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(212, 160, 23, 0.3);
        }

        .section-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.2rem;
            margin-bottom: 60px;
        }

        .islands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .island-card {
            group position: relative;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(212, 160, 23, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            height: 400px;
            display: flex;
            flex-direction: column;
        }

        .island-card:hover {
            border-color: rgba(212, 160, 23, 0.6);
            transform: translateY(-20px);
            box-shadow: 0 30px 60px rgba(193, 68, 14, 0.3), 0 0 40px rgba(212, 160, 23, 0.2);
        }

        .island-header {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            background: linear-gradient(135deg, rgba(193, 68, 14, 0.2), rgba(212, 160, 23, 0.15));
            position: relative;
            overflow: hidden;
        }

        .island-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .island-card:hover .island-header::after {
            transform: translateX(100%);
        }

        .island-body {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .island-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #FFD700;
            margin-bottom: 12px;
        }

        .island-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            line-height: 1.6;
            flex: 1;
        }

        .island-cta {
            color: #D4A017;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .island-card:hover .island-cta {
            color: #FFD700;
            transform: translateX(5px);
        }

        .cta-section {
            position: relative;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            overflow: hidden;
        }

        .cta-bg-elements {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .cta-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(50px);
        }

        .cta-blob-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(193, 68, 14, 0.2), rgba(212, 160, 23, 0.1));
            top: -100px;
            right: -100px;
        }

        .cta-blob-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, rgba(31, 122, 140, 0.1), rgba(193, 68, 14, 0.1));
            bottom: -50px;
            left: -50px;
        }

        .cta-content {
            position: relative;
            z-index: 5;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: #FFD700;
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(212, 160, 23, 0.3);
        }

        .cta-text {
            color: rgba(255, 255, 255, 0.75);
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .footer {
            position: relative;
            padding: 60px 20px 40px;
            background: linear-gradient(180deg, #0a0e27 0%, #0a0e27 100%);
            border-top: 1px solid rgba(212, 160, 23, 0.2);
            text-align: center;
            z-index: 10;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FFD700, #D4A017);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .footer-tagline {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
            margin-bottom: 30px;
            font-style: italic;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .footer-link:hover {
            color: #FFD700;
        }

        .footer-bottom {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.9rem;
            padding-top: 30px;
            border-top: 1px solid rgba(212, 160, 23, 0.1);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                letter-spacing: -1px;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-cta {
                gap: 10px;
                justify-content: center;
            }

            .btn {
                padding: 12px 30px;
                font-size: 1rem;
            }

            .game-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }

            .game-card {
                font-size: 1.5rem;
            }

            .feature-card {
                padding: 30px;
            }

            .island-card {
                height: 350px;
            }

            .section-title {
                font-size: 2rem;
            }

            .footer-links {
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section (Game Portal Entry) -->
    <section class="hero-section">
        <div class="floating-blob blob-1"></div>
        <div class="floating-blob blob-2"></div>
        <div class="floating-blob blob-3"></div>
        <div class="hero-bg"></div>
        <div class="hero-pattern"></div>

        <!-- Glow Dots -->
        <div class="glow-dot"></div>
        <div class="glow-dot"></div>
        <div class="glow-dot"></div>
        <div class="glow-dot"></div>

        <div class="hero-content">
            <h1 class="hero-title">Trilogi Nusantara</h1>
            <p class="hero-subtitle">
                Jelajahi keindahan Indonesia melalui permainan memori yang seru dan edukatif!
            </p>
            <div class="hero-cta">
                <a href="#" class="btn btn-play">▶ Mainkan Sekarang</a>
                <a href="#" class="btn btn-secondary">Daftar</a>
                {{-- <a href="{{ route('home') }}" class="btn btn-play">▶ Mainkan Sekarang</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Daftar</a> --}}
            </div>
        </div>
    </section>

    <!-- Game Preview Section -->
    <section class="preview-section">
        <div class="preview-bg-glow"></div>
        <div class="preview-container">
            <h2 class="preview-title">Bagaimana Cara Bermain?</h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                <!-- Steps -->
                <div style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">
                @php
                    $steps = [
                        ['number' => 1, 'color' => '#C1440E', 'title' => 'Pilih Pulau', 'desc' => 'Mulai dari Sumatera, Jawa, Bali, Kalimantan, Sulawesi, atau Papua'],
                        ['number' => 2, 'color' => '#D4A017', 'title' => 'Buka 3 Kartu', 'desc' => 'Buka tiga kartu sekaligus untuk mencari trilogi yang cocok'],
                        ['number' => 3, 'color' => '#1F7A8C', 'title' => 'Cocokkan Trilogi', 'desc' => 'Tiga kartu berkaitan akan hilang (gambar + nama + deskripsi)'],
                        ['number' => 4, 'color' => '#FF6B35', 'title' => 'Raih Poin', 'desc' => 'Semakin cepat selesai, semakin banyak poin yang didapat'],
                    ];
                @endphp

                @foreach($steps as $step)
                    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                        <div style="background: {{ $step['color'] }}; color: {{ $step['number'] === 2 ? '#0a0e27' : 'white' }}; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.3rem; flex-shrink: 0;">{{ $step['number'] }}</div>
                        <div>
                            <h3 style="color: #FFD700; font-weight: 700; margin-bottom: 8px;">{{ $step['title'] }}</h3>
                            <p>{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
                </div>

                <!-- Game Grid -->
                <div class="game-grid">
                    @php
                        $gameCards = [
                            ['type' => 'image', 'src' => asset('images/trilogi/lawangsewu.jpg')],
                            ['type' => 'default', 'text' => '?'],
                            ['type' => 'default', 'text' => '?'],
                            ['type' => 'text', 'text' => 'Lawang Sewu'],
                            ['type' => 'default', 'text' => '?'],
                            ['type' => 'default', 'text' => '?'],
                            ['type' => 'default', 'text' => '?'],
                            ['type' => 'text', 'text' => 'Gedung Seribu Pintu'],
                            ['type' => 'default', 'text' => '?'],
                        ];
                    @endphp
                    
                    @foreach($gameCards as $card)
                        @if($card['type'] === 'image')
                            <div class="game-card image-card">
                                <img src="{{ $card['src'] }}" alt="Card Image" class="card-image">
                            </div>
                        @elseif($card['type'] === 'text')
                            <div class="game-card text-card">
                                <div class="card-text">{{ $card['text'] }}</div>
                            </div>
                        @elseif($card['type'] === 'matched')
                            <div class="game-card matched">{{ $card['text'] }}</div>
                        @else
                            <div class="game-card">{{ $card['text'] }}</div>
                        @endif
                    @endforeach
                    <div class="game-card">?</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-grid">
            @php
                $features = [
                    ['icon' => '🧠', 'title' => 'Tantangan Memori', 'desc' => 'Asah kemampuan kognitif dengan mekanik memory card yang seru dan challenging'],
                    ['icon' => '🌏', 'title' => 'Jelajahi Indonesia', 'desc' => 'Pelajari keunikan budaya dari Sabang sampai Merauke melalui kartu trilogi edukatif'],
                    ['icon' => '🏆', 'title' => 'Gameplay Seru', 'desc' => 'Naik level, raih nilai tertinggi, dan bersaing dengan pemain lain di leaderboard'],
                ];
            @endphp

            @foreach($features as $feature)
                <div class="feature-card">
                    <div class="feature-icon">{{ $feature['icon'] }}</div>
                    <div class="feature-title">{{ $feature['title'] }}</div>
                    <div class="feature-desc">{{ $feature['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-title">Trilogi Nusantara</div>
            <div class="footer-tagline">"Temukan, Hubungkan, Jelajahi Nusantara."</div>
            <div class="footer-links">
                <a href="#" class="footer-link">Beranda</a>
                <a href="#" class="footer-link">Tentang Kami</a>
                <a href="#" class="footer-link">Hubungi Kami</a>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Trilogi Nusantara
            </div>
        </div>
    </footer>
</body>
</html>
