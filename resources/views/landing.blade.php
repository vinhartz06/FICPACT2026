<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Trilogi Nusantara | Permainan Memori Nusantara</title>
    @vite(['resources/css/app.css'])
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

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes bounce-icon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
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
            background-image:
                linear-gradient(180deg, rgba(10, 14, 39, 0.45) 0%, rgba(26, 26, 46, 0.5) 50%, rgba(10, 14, 39, 0.55) 100%),
                url('{{ asset("images/indonesia.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 1;
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
            font-size: clamp(2.5rem, 10vw, 7rem);
            font-weight: 900;
            background: linear-gradient(135deg, #FFD700, #FFA500, #FF6B6B, #D4A017);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(212, 160, 23, 0.3);
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 4vw, 1.5rem);
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 40px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .hero-cta {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 32px;
            font-size: 1rem;
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

        .btn-masuk {
            background: rgba(255, 255, 255, 0.1);
            color: #FFD700;
            border: 2px solid #D4A017;
            backdrop-filter: blur(10px);
        }

        .btn-masuk:hover {
            background: rgba(212, 160, 23, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 160, 23, 0.3);
        }

        .preview-section {
            position: relative;
            min-height: auto;
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
            max-width: 1200px;
            width: 100%;
            position: relative;
            z-index: 5;
        }

        .preview-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #FFD700;
            text-align: center;
            margin-bottom: 50px;
            text-shadow: 0 0 20px rgba(212, 160, 23, 0.3);
        }

        /* RESPONSIVE LAYOUT: STEPS ON TOP, CARDS BELOW ON MOBILE */
        .gameplay-layout {
            display: flex;
            flex-direction: row;
            gap: 60px;
            align-items: flex-start;
        }

        .steps-wrapper {
            flex: 1;
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
        }

        .game-grid-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .step-item {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .step-title {
            color: #FFD700;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.2rem;
        }

        .step-desc {
            font-size: 0.95rem;
            line-height: 1.5;
            color: rgba(255,255,255,0.7);
        }

        /* SMALLER BOXES - REDUCED SIZE */
        .game-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            perspective: 1000px;
            max-width: 360px;
            width: 100%;
        }

        .game-card {
            aspect-ratio: 1;
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.2), rgba(193, 68, 14, 0.2));
            border: 2px solid rgba(212, 160, 23, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            flex-direction: column;
            gap: 4px;
        }

        .game-card.text-card {
            background: linear-gradient(135deg, rgba(212, 160, 23, 0.15), rgba(193, 68, 14, 0.15));
            padding: 8px;
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
            font-size: clamp(0.65rem, 2.5vw, 0.75rem);
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-weight: 600;
            word-break: break-word;
            line-height: 1.2;
        }

        .game-card:hover {
            transform: rotateY(15deg) translateZ(20px) scale(1.05);
            box-shadow: 0 10px 40px rgba(212, 160, 23, 0.4), inset 0 0 20px rgba(212, 160, 23, 0.1);
            border-color: rgba(212, 160, 23, 0.6);
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

        /* Features Section */
        .features-section {
            position: relative;
            min-height: auto;
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
            padding: 40px 30px;
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

        /* Islands Section */
        .islands-section {
            position: relative;
            min-height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(180deg, #0f3460 0%, #1a1a2e 100%);
        }

        .islands-container {
            max-width: 1400px;
            width: 100%;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #FFD700;
            text-align: center;
            margin-bottom: 20px;
        }

        .section-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.2rem;
            margin-bottom: 60px;
        }

        .islands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .island-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(212, 160, 23, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .island-card:hover {
            border-color: rgba(212, 160, 23, 0.6);
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(193, 68, 14, 0.3);
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

        .island-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .island-name {
            font-size: 1.6rem;
            font-weight: 700;
            color: #FFD700;
            margin-bottom: 12px;
        }

        .island-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            line-height: 1.5;
            flex: 1;
        }

        .island-cta {
            color: #D4A017;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            transition: all 0.3s ease;
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
        }

        .cta-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 5;
        }

        .cta-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: #FFD700;
            margin-bottom: 20px;
        }

        .cta-text {
            color: rgba(255, 255, 255, 0.75);
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .footer {
            position: relative;
            padding: 60px 20px 40px;
            background: linear-gradient(180deg, #0a0e27 0%, #0a0e27 100%);
            border-top: 1px solid rgba(212, 160, 23, 0.2);
            text-align: center;
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
            font-size: 1rem;
            margin-bottom: 30px;
            font-style: italic;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: all 0.3s ease;
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

        /* MOBILE RESPONSIVE ADJUSTMENTS */
        @media (max-width: 992px) {
            .gameplay-layout {
                gap: 40px;
            }
            .game-grid {
                max-width: 320px;
                gap: 10px;
            }
            .game-card {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 768px) {
            .hero-cta {
                gap: 12px;
            }
            .btn {
                padding: 10px 24px;
                font-size: 0.9rem;
            }
            
            /* STACK LAYOUT: Steps on top, cards below */
            .gameplay-layout {
                flex-direction: column;
                gap: 50px;
            }
            
            .steps-wrapper {
                order: 1;
            }
            
            .game-grid-wrapper {
                order: 2;
                display: flex;
                justify-content: center;
            }
            
            .step-item {
                margin-bottom: 25px;
            }
            
            .step-number {
                width: 44px;
                height: 44px;
                font-size: 1.1rem;
            }
            
            .step-title {
                font-size: 1.1rem;
            }
            
            .step-desc {
                font-size: 0.85rem;
            }
            
            /* SMALLER BOXES ON MOBILE TOO */
            .game-grid {
                max-width: 280px;
                gap: 8px;
            }
            
            .game-card {
                font-size: 1.2rem;
            }
            
            .card-text {
                font-size: 0.65rem;
            }
            
            .feature-card {
                padding: 30px 20px;
            }
            
            .island-card {
                margin-bottom: 10px;
            }
            
            .island-name {
                font-size: 1.4rem;
            }
            
            .preview-title {
                margin-bottom: 40px;
            }
        }

        @media (max-width: 480px) {
            .game-grid {
                max-width: 240px;
                gap: 6px;
            }
            
            .game-card {
                font-size: 1rem;
                border-radius: 10px;
                border-width: 1.5px;
            }
            
            .card-text {
                font-size: 0.6rem;
            }
            
            .step-number {
                width: 38px;
                height: 38px;
                font-size: 0.9rem;
            }
            
            .step-item {
                gap: 12px;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
            
            .btn {
                padding: 8px 20px;
                font-size: 0.85rem;
            }
        }

        /* Modal Popup Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeInUp 0.3s ease;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 24px;
            max-width: 500px;
            width: 90%;
            padding: 30px;
            position: relative;
            border: 1px solid rgba(212, 160, 23, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(212, 160, 23, 0.2);
            animation: fadeInUp 0.4s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(212, 160, 23, 0.2);
            padding-bottom: 15px;
        }

        .modal-header h2 {
            color: #FFD700;
            font-size: 1.8rem;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 28px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: rgba(212, 160, 23, 0.2);
            color: #FFD700;
            transform: rotate(90deg);
        }

        .modal-body {
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        .about-text {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 0;
            border-bottom: 1px solid rgba(212, 160, 23, 0.1);
        }

        .contact-icon {
            font-size: 1.5rem;
            min-width: 40px;
        }

        .contact-info {
            flex: 1;
        }

        .contact-info a {
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .contact-label {
            font-weight: 600;
            color: #fff;
            margin-bottom: 1px;
            font-size: 0.85rem;
        }

        .contact-value {
            font-size: 0.85rem;
        }

        .team-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .team-member {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 15px;
            border: 1px solid rgba(212, 160, 23, 0.2);
        }

        .team-member h3 {
            color: #FFD700;
            margin-bottom: 7px;
            font-size: 1.2rem;
        }

        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 5px;
        }

        .social-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .social-link:hover {
            color: #FFD700;
            transform: translateY(-2px);
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 20px;
            }
            
            .team-member {
                padding: 12px;
            }
            
            .contact-item {
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-blob blob-1"></div>
        <div class="floating-blob blob-2"></div>
        <div class="floating-blob blob-3"></div>
        <div class="hero-bg"></div>
        <div class="hero-pattern"></div>
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
                <a href="{{ route('login') }}" class="btn btn-masuk">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Daftar</a>
            </div>
        </div>
    </section>

    <!-- Game Preview Section - FULLY RESPONSIVE: text on top, cards below on mobile, SMALLER BOXES -->
    <section class="preview-section">
        <div class="preview-bg-glow"></div>
        <div class="preview-container">
            <h2 class="preview-title">Bagaimana Cara Bermain?</h2>
            <div class="gameplay-layout">
                <!-- Steps (text) - will be on top for mobile -->
                <div class="steps-wrapper">
                    @php
                        $steps = [
                            ['number' => 1, 'color' => '#C1440E', 'title' => 'Pilih Pulau', 'desc' => 'Mulai dari Sumatera, Jawa, Bali, Kalimantan, Sulawesi, atau Papua'],
                            ['number' => 2, 'color' => '#D4A017', 'title' => 'Buka 3 Kartu', 'desc' => 'Buka tiga kartu sekaligus untuk mencari trilogi yang cocok'],
                            ['number' => 3, 'color' => '#1F7A8C', 'title' => 'Cocokkan Trilogi', 'desc' => 'Tiga kartu berkaitan akan hilang (gambar + nama + deskripsi)'],
                            ['number' => 4, 'color' => '#FF6B35', 'title' => 'Raih Poin', 'desc' => 'Semakin cepat selesai, semakin banyak poin yang didapat'],
                        ];
                    @endphp
                    @foreach($steps as $step)
                        <div class="step-item">
                            <div class="step-number" style="background: {{ $step['color'] }}; color: {{ $step['number'] === 2 ? '#0a0e27' : 'white' }};">
                                {{ $step['number'] }}
                            </div>
                            <div>
                                <h3 class="step-title">{{ $step['title'] }}</h3>
                                <p class="step-desc">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Game Grid (cards) - SMALLER BOX SIZE -->
                <div class="game-grid-wrapper">
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
                            @else
                                <div class="game-card">{{ $card['text'] }}</div>
                            @endif
                        @endforeach
                        <div class="game-card">?</div>
                    </div>
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
                <a href="#" class="footer-link">Tentang Kami</a>
                <a href="#" class="footer-link">Hubungi Kami</a>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Trilogi Nusantara
            </div>
        </div>
    </footer>

    <!-- Modal Tentang Kami -->
    <div id="aboutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tentang Kami</h2>
                <button class="modal-close" onclick="closeModal('aboutModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="about-text">
                    <strong>Trilogi Nusantara</strong> adalah permainan memori edukatif berbasis kartu yang mengajak pemain mengenal kekayaan budaya Indonesia melalui cara yang seru dan interaktif. Dalam permainan ini, pemain dapat menjelajahi berbagai pulau dan kota di Nusantara beserta budaya, sejarah, dan ciri khasnya.
                    Dikembangkan oleh Vincent dan Radit, mahasiswa Teknik Informatika Soegijapranata Catholic University, permainan ini bertujuan menghadirkan pengalaman belajar budaya Indonesia yang menyenangkan sekaligus membantu melestarikan warisan budaya Nusantara dengan cara yang modern.
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hubungi Kami -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Hubungi Kami</h2>
                <button class="modal-close" onclick="closeModal('contactModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="team-grid">
                    <div class="team-member">
                        <h3>Jonathan Vincent</h3>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.85-.07zM12 0C8.741 0 8.332.012 7.052.07 5.763.128 4.75.358 3.877.83c-.902.493-1.668 1.144-2.331 1.807-.663.663-1.314 1.429-1.807 2.331-.472.873-.702 1.886-.76 3.175C.012 8.332 0 8.741 0 12s.012 3.668.07 4.948c.058 1.289.288 2.302.76 3.175.493.902 1.144 1.668 1.807 2.331.663.663 1.429 1.314 2.331 1.807.873.472 1.886.702 3.175.76 1.28.058 1.689.07 4.948.07s3.668-.012 4.948-.07c1.289-.058 2.302-.288 3.175-.76.902-.493 1.668-1.144 2.331-1.807.663-.663 1.314-1.429 1.807-2.331.472-.873.702-1.886.76-3.175.058-1.28.07-1.689.07-4.948s-.012-3.668-.07-4.948c-.058-1.289-.288-2.302-.76-3.175-.493-.902-1.144-1.668-1.807-2.331-.663-.663-1.429-1.314-2.331-1.807-.873-.472-1.886-.702-3.175-.76C15.668.012 15.259 0 12 0z" fill="#FFD700"/>
                                    <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8z" fill="#FFD700"/>
                                    <circle cx="18.406" cy="5.594" r="1.44" fill="#FFD700"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Instagram</div>
                                <div class="contact-value"><a href="https://instagram.com/j.vincent2006" target="_blank">@j.vincent2006</a></div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 0.296c-6.627 0-12 5.373-12 12 0 5.302 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.296c0-6.627-5.373-12-12-12z" fill="#FFD700"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">GitHub</div>
                                <div class="contact-value"><a href="https://github.com/vinhartz06" target="_blank">github.com/vinhartz06</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="team-member">
                        <h3>Claudio Raditya</h3>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.85-.07zM12 0C8.741 0 8.332.012 7.052.07 5.763.128 4.75.358 3.877.83c-.902.493-1.668 1.144-2.331 1.807-.663.663-1.314 1.429-1.807 2.331-.472.873-.702 1.886-.76 3.175C.012 8.332 0 8.741 0 12s.012 3.668.07 4.948c.058 1.289.288 2.302.76 3.175.493.902 1.144 1.668 1.807 2.331.663.663 1.429 1.314 2.331 1.807.873.472 1.886.702 3.175.76 1.28.058 1.689.07 4.948.07s3.668-.012 4.948-.07c1.289-.058 2.302-.288 3.175-.76.902-.493 1.668-1.144 2.331-1.807.663-.663 1.314-1.429 1.807-2.331.472-.873.702-1.886.76-3.175.058-1.28.07-1.689.07-4.948s-.012-3.668-.07-4.948c-.058-1.289-.288-2.302-.76-3.175-.493-.902-1.144-1.668-1.807-2.331-.663-.663-1.429-1.314-2.331-1.807-.873-.472-1.886-.702-3.175-.76C15.668.012 15.259 0 12 0z" fill="#FFD700"/>
                                    <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8z" fill="#FFD700"/>
                                    <circle cx="18.406" cy="5.594" r="1.44" fill="#FFD700"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Instagram</div>
                                <div class="contact-value"><a href="https://instagram.com/cradityabp" target="_blank">@cradityabp</a></div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 0.296c-6.627 0-12 5.373-12 12 0 5.302 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.305.762-1.604-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.296c0-6.627-5.373-12-12-12z" fill="#FFD700"/>
                                </svg>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">GitHub</div>
                                <div class="contact-value"><a href="https://github.com/pamungkas06" target="_blank">github.com/pamungkas06</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/auth.js"></script>
<script src="js/landing.js"></script>
</html>