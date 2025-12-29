<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Little Stars Daycare — Nurturing Bright Beginnings</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fredoka-one:400|nunito:400,600,700,800,900&display=swap" rel="stylesheet" />
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html {
            height: 100%;
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Keep system scrollbar for accessibility */
        body::-webkit-scrollbar { width: 8px; }
        body { -ms-overflow-style: auto; scrollbar-width: auto; }
        
        /* Each section is full viewport */
        section {
            height: 100vh;
            width: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        
        /* Confetti Canvas - lightweight */
        #confetti-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
        
        /* ========== SECTION 1: HERO ========== */
        .hero {
            background: linear-gradient(180deg, #74b9ff 0%, #81ecec 50%, #55efc4 100%);
        }
        
        /* Animated clouds */
        .cloud {
            position: absolute;
            background: white;
            border-radius: 100px;
            box-shadow: 0 10px 30px rgba(255,255,255,0.5);
        }
        
        .cloud::before, .cloud::after {
            content: '';
            position: absolute;
            background: white;
            border-radius: 50%;
        }
        
        .cloud-1 { width: 200px; height: 60px; top: 10%; left: -200px; animation: cloudMove 30s linear infinite; }
        .cloud-1::before { width: 100px; height: 100px; top: -50px; left: 20px; }
        .cloud-1::after { width: 70px; height: 70px; top: -35px; right: 30px; }
        
        .cloud-2 { width: 150px; height: 45px; top: 25%; left: -150px; animation: cloudMove 40s linear infinite; animation-delay: -15s; }
        .cloud-2::before { width: 70px; height: 70px; top: -35px; left: 15px; }
        .cloud-2::after { width: 50px; height: 50px; top: -25px; right: 20px; }
        
        .cloud-3 { width: 180px; height: 55px; top: 5%; left: -180px; animation: cloudMove 35s linear infinite; animation-delay: -25s; }
        .cloud-3::before { width: 90px; height: 90px; top: -45px; left: 25px; }
        .cloud-3::after { width: 60px; height: 60px; top: -30px; right: 25px; }
        
        @keyframes cloudMove { 0% { left: -250px; } 100% { left: 110%; } }
        
        /* Sun */
        .sun {
            position: absolute;
            top: 50px;
            right: 100px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, #fff176 0%, #ffeb3b 50%, #ffc107 100%);
            border-radius: 50%;
            box-shadow: 0 0 80px #ffeb3b, 0 0 150px rgba(255,235,59,0.5);
            animation: sunPulse 4s ease-in-out infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }
        
        @keyframes sunPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        /* Ground */
        .ground {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 180px;
            background: linear-gradient(180deg, #55efc4 0%, #00b894 50%, #00a085 100%);
        }
        
        /* Interactive Mascot */
        .mascot-container { position: absolute; bottom: 180px; left: 50%; transform: translateX(-50%); z-index: 10; }
        
        .mascot {
            font-size: 150px;
            cursor: pointer;
            transition: transform 0.3s ease;
            animation: mascotBounce 2s ease-in-out infinite;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.2));
        }
        
        .mascot:hover { transform: scale(1.2) rotate(10deg); animation: none; }
        
        @keyframes mascotBounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        
        .speech-bubble {
            position: absolute;
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 15px 25px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #6c5ce7;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border: 15px solid transparent;
            border-top-color: white;
        }
        
        .mascot-container:hover .speech-bubble { opacity: 1; }
        
        /* Hero content */
        .hero-content { position: relative; z-index: 5; text-align: center; margin-top: -180px; }
        
        .hero-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3.5rem;
            color: white;
            text-shadow: 4px 4px 0 #6c5ce7, 8px 8px 0 rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        
        .hero-subtitle {
            font-size: 1.8rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Floating navigation */
        .nav-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 15px;
        }
        
        .nav-btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .nav-btn-login { background: white; color: #6c5ce7; box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        .nav-btn-register { background: linear-gradient(135deg, #fd79a8, #e84393); color: white; box-shadow: 0 5px 20px rgba(253,121,168,0.5); }
        .nav-btn:hover { transform: translateY(-5px) scale(1.1); }
        
        /* ========== SECTION 2: ACTIVITIES ========== */
        .activities { background:linear-gradient(180deg,#a29bfe 0%,#6c5ce7 100%); padding:60px 20px; }

        .activity-icon {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 6px 10px rgba(0,0,0,0.2));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float { 0%,100%{transform:translateY(0);}50%{transform:translateY(-6px);} }

        .activity-card:hover .activity-icon { transform: scale(1.15) rotate(-5deg); }

        .activities::before,
        .game-section::before,
        .testimonials::before {
            content: '🎈 ⭐ 🖍️ 🌈 🧩';
            position: absolute;
            font-size: 80px;
            opacity: 0.08;
            top: 10%;
            left: 5%;
            transform: rotate(-10deg);
            pointer-events: none;
        }

        /* 3D Flip Cards */
        .activity-grid { display:grid; grid-template-columns:repeat(4,280px); gap:30px; justify-content:center; perspective:1000px; }

        .activity-card {
            width: 280px;
            height: 350px;
            perspective: 1000px;
            cursor: pointer;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s ease;
        }

        /* Flip the card when hovering the container */
        .activity-card:hover {
            transform: rotateY(180deg);
        }

        /* Front and back sides */
        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            pointer-events: none; /* ensures hover applies to the whole card */
        }

        /* Front stays normal */
        .card-front {
            background: white;
        }

        /* Back rotated */
        .card-back {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, #fd79a8, #e84393);
            color: white;
        }

        /* Optional: allow clicks inside card content */
        .card-front * , .card-back * {
            pointer-events: auto;
        }


        .card-front .icon { font-size: 80px; margin-bottom:15px; }
        .card-front h3 { font-family:'Fredoka One', cursive; font-size:1.5rem; color:#6c5ce7; margin-bottom:10px; }
        .card-front p { color:#666; text-align:center; font-size:1rem; }
        .card-back h3 { font-size:1.3rem; margin-bottom:15px; }
        .card-back ul { list-style:none; text-align:left; }
        .card-back li { padding:6px 0; font-size:1rem; }
        .card-back li::before { content:'✨ '; }

        .testimonial-marquee {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .testimonial-track {
            display: flex;
            width: max-content;
            animation: marquee 30s linear infinite;
        }

        .testimonial-avatar-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(135deg, #fd79a8, #6c5ce7);
            margin: 0 auto 15px;
        }

        .testimonial-avatar-wrap img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            background: white;
        }


        /* .testimonial-track:hover {
            animation-play-state: paused;
        } */

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }


        
        .section-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3.5rem;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 3px 3px 0 rgba(0,0,0,0.2);
        }
        
        .section-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.9);
            font-size: 1.3rem;
            margin-bottom: 50px;
        }
        
        /* 3D Flip Cards */
        .activity-grid {
            display: grid;
            grid-template-columns: repeat(4, 280px);
            gap: 30px;
            justify-content: center;
            perspective: 1000px;
        }
        
        .activity-card {
            height: 350px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
            cursor: pointer;
        }
        
        /* Hover flips the card forward the same way */
        .activity-card:hover {
            transform: rotateY(180deg);
        }

        /* Cute wobble instead of stiff hover */
        @keyframes wobble {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(2deg); }
            50% { transform: rotate(-2deg); }
            75% { transform: rotate(1deg); }
            100% { transform: rotate(0deg); }
        }

        /* .activity-card:hover {
            animation: wobble 0.6s ease;
        } */

        /* Flip effect (already mostly in your CSS) */
        .activity-card {
            perspective: 1000px;
            transition: transform 0.8s ease;
            transform-style: preserve-3d;
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        /* Front stays normal */
        .card-front { 
            background: white; 
        }

        /* Back is rotated by 180° */
        .card-back {
            transform: rotateY(180deg);
            color: white;
        }

        .card-back-art {
            background: linear-gradient(135deg, #fd79a8, #e84393); /* pink gradient */
        }

        .card-back-story {
            background: linear-gradient(135deg, #74b9ff, #0984e3); /* blue gradient */
        }

        .card-back-music {
            background: linear-gradient(135deg, #ffeaa7, #fab1a0); /* yellow-orange */
        }

        .card-back-play {
            background: linear-gradient(135deg, #55efc4, #00b894); /* green gradient */
        }


        /* Hover flips the card forward the same way */
        .activity-card:hover {
            transform: rotateY(180deg);
        }
  
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        /* Softer cards */
        .card-front, .card-back,
        .testimonial-card,
        .game-container {
            border-radius: 32px;
            box-shadow:
                0 15px 40px rgba(0,0,0,0.2),
                inset 0 4px 0 rgba(255,255,255,0.4);
        }

        
        .card-front { background: white; }
        
        .card-front .icon { font-size: 80px; margin-bottom: 15px; }
        .card-front h3 { font-family: 'Fredoka One', cursive; font-size: 1.5rem; color: #6c5ce7; margin-bottom: 10px; }
        .card-front p { color: #666; text-align: center; font-size: 1rem; }
        
        .card-back h3 { font-size: 1.3rem; margin-bottom: 15px; }
        .card-back ul { list-style: none; text-align: left; }
        .card-back li { padding: 6px 0; font-size: 1rem; }
        .card-back li::before { content: '✨ '; }
        
        /* Card interaction improvements */
        .activity-card {
            width: 280px;
            height: 350px;
            position: relative;
            cursor: pointer;
            transition: transform 220ms ease, box-shadow 220ms ease;
            border-radius: 25px;
            background: transparent;
            will-change: transform;
        }

        /* Pop-up effect on hover */
        .activity-card:hover {
            transform: translateY(-14px) scale(1.03) rotate(-0.5deg);
            box-shadow: 0 30px 70px rgba(0,0,0,0.16);
        }

        /* Inner element handles the 3D flip (controlled via class, not hover) */
        .activity-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 640ms cubic-bezier(.2,1,.2,1);
            transform-style: preserve-3d;
            border-radius: inherit;
            background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.96));
            overflow: hidden;
        }

        /* Flip only when the card has the `flipped` class */
        .activity-card.flipped .activity-card-inner {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: inherit;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 26px;
        }

        /* Activity icon wrap */
        .activity-icon-wrap {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(108,92,231,0.12), rgba(253,121,168,0.12));
            box-shadow: 0 10px 30px rgba(0,0,0,0.06) inset;
            margin-bottom: 14px;
        }

        .activity-icon { width: 68px; height: 68px; object-fit: contain; }

        .activity-title { font-size: 1.2rem; color: #6c5ce7; margin-bottom: 6px; }
        .activity-lead { font-size: 0.95rem; color: #6b7280; text-align: center; }

        /* Small badge (corner) */
        .activity-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: linear-gradient(135deg,#ffb86b,#fd79a8);
            color: white;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.85rem;
            box-shadow: 0 6px 18px rgba(253,121,168,0.18);
        }

        /* Back content */
        .card-back { color: white; padding: 22px; }
        .card-back h3 { margin-bottom: 12px; font-size: 1.1rem; }
        .card-back ul { margin-bottom: 14px; }
        .card-back .btn-small { padding: 8px 14px; border-radius: 999px; font-size: 0.9rem; font-weight: 700; color: white; background: linear-gradient(90deg, rgba(0,206,201,0.95), rgba(0,184,148,0.95)); box-shadow: 0 10px 30px rgba(0,206,201,0.12); text-decoration: none; display: inline-block; }

        /* Testimonials grid */
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0,1fr));
            gap: 20px;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: white;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            text-align: left;
        }

        .testimonial-card .avatar { width: 68px; height: 68px; border-radius: 50%; overflow: hidden; margin-bottom: 12px; }
        .testimonial-name { font-weight: 800; color: #6c5ce7; margin-top: 10px; }
        .testimonial-text { color: #4b5563; line-height: 1.6; }
        .stars { color: #ffbf00; margin-bottom: 8px; }

        .testimonial-actions { margin-top: 14px; }

        /* Footer */
        .site-footer { background: linear-gradient(180deg,#2d3436 0%, #2b2f36 100%); color: rgba(255,255,255,0.92); padding: 48px 20px; }
        .site-footer a { color: rgba(255,255,255,0.9); text-decoration: none; }
        .site-footer .col { min-width: 200px; }

        @media (max-width: 992px) {
            .testimonial-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
        }
        @media (max-width: 640px) {
            .testimonial-grid { grid-template-columns: 1fr; }
            .activity-card { width: 90%; transform: none; }
        }

        /* ========== SECTION 3: GAME ========== */
        .game-section {
            background: linear-gradient(180deg, #ffeaa7 0%, #fdcb6e 100%);
            padding: 60px 20px;
        }
        
        .game-container {
            max-width: 700px;
            width: 90%;
            background: white;
            border-radius: 40px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
        }
        
        .game-title { font-family: 'Fredoka One', cursive; font-size: 2.2rem; color: #e17055; margin-bottom: 20px; text-align: center; }
        
        .catch-game {
            height: 250px;
            background: linear-gradient(180deg, #74b9ff, #a29bfe);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            cursor: crosshair;
            margin-bottom: 20px;
        }
        
        .catch-item { position: absolute; font-size: 45px; cursor: pointer; user-select: none; transition: transform 0.1s; }
        .catch-item:hover { transform: scale(1.3); }
        
        .game-score { font-size: 1.3rem; font-weight: 800; color: #6c5ce7; text-align: center; }
        .game-instructions { color: #666; margin-bottom: 15px; font-size: 1.1rem; text-align: center; }
        
        /* ========== SECTION 4: TESTIMONIALS ========== */
        .testimonials {
            background: linear-gradient(180deg, #fd79a8 0%, #e84393 100%);
            padding: 60px 20px;
        }
        
        .testimonial-track {
            display: flex;
            animation: scroll 25s linear infinite;
            width: max-content;
        }
        
        /* .testimonial-track:hover { animation-play-state: paused; } */
        
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        
        .testimonial-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            margin: 0 15px;
            min-width: 320px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .testimonial-avatar { font-size: 60px; margin-bottom: 15px; }
        .testimonial-text { font-size: 1rem; color: #666; line-height: 1.7; margin-bottom: 15px; }
        .testimonial-name { font-weight: 800; color: #6c5ce7; font-size: 1.1rem; }
        
        /* ========== SECTION 5: CTA ========== */
        .cta-section {
            background: linear-gradient(135deg, #2d3436 0%, #636e72 100%);
            padding: 60px 20px;
        }
        
        .cta-stars {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
        }
        
        .cta-star {
            position: absolute;
            font-size: 1.5rem;
            opacity: 0.2;
            animation: twinkle 3s ease-in-out infinite;
        }
        
        @keyframes twinkle { 0%, 100% { opacity: 0.2; } 50% { opacity: 0.5; } }
        
        .cta-content { position: relative; z-index: 1; text-align: center; }
        
        .cta-section h2 { font-family: 'Fredoka One', cursive; font-size: 3.5rem; color: white; margin-bottom: 20px; }
        .cta-section p { font-size: 1.4rem; color: rgba(255,255,255,0.8); margin-bottom: 40px; }
        
        .mega-btn {
            display: inline-block;
            padding: 22px 55px;
            font-family: 'Fredoka One', cursive;
            font-size: 1.8rem;
            color: white;
            background: linear-gradient(135deg, #00cec9, #00b894);
            border-radius: 60px;
            text-decoration: none;
            box-shadow: 0 10px 40px rgba(0,206,201,0.5);
            transition: all 0.3s ease;
        }
        
        .mega-btn:hover { transform: translateY(-10px) scale(1.05); box-shadow: 0 20px 60px rgba(0,206,201,0.6); }
        
        /* Footer within CTA */
        .footer-text { margin-top: 60px; color: rgba(255,255,255,0.6); font-size: 0.95rem; }
        .footer-text a { color: #00cec9; text-decoration: none; font-weight: 600; }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .activity-grid { grid-template-columns: repeat(2, 280px); }
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.8rem; }
            .mascot { font-size: 100px; }
            .section-title { font-size: 2.2rem; }
            .activity-grid { grid-template-columns: 280px; }
            .nav-float { top: 10px; right: 10px; }
            .nav-btn { padding: 10px 20px; font-size: 0.9rem; }
            .cta-section h2 { font-size: 2.2rem; }
        }
    </style>
</head>
<body>
    <!-- Minimal Confetti Canvas -->
    <canvas id="confetti-canvas"></canvas>
    
    <!-- Brand header -->
    <div class="fixed z-50 left-6 top-6">
        <a href="/" class="flex items-center gap-3 text-white no-underline">
            <!-- <x-application-logo class="w-10 h-10" />
            <div class="hidden md:block">
                <div class="font-bold text-white text-lg">Little Stars</div>
                <div class="text-xs text-white/80">Nurturing bright beginnings</div>
            </div> -->
        </a>
    </div>

    <!-- Floating Navigation -->
    <div class="nav-float">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-btn nav-btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-btn nav-btn-login" aria-label="Login">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-register" aria-label="Register">Join</a>
                @endif
            @endauth
        @endif
    </div>
    
    <!-- SECTION 1: Hero -->
    <section class="hero">
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="sun">😊</div>
        
        <div class="hero-content">
            <h1 class="hero-title">Little Stars Daycare</h1>
            <p class="hero-subtitle">A safe, playful environment for early learning.</p>
        </div>
        
        <div class="mascot-container">
            <div class="speech-bubble" id="speech">Tap the mascot</div>
            <div class="mascot" id="mascot" onclick="mascotClick()" role="button" aria-label="Mascot" tabindex="0">🧸</div>
        </div>
        
        <!-- Ground -->
        <div class="ground"></div>
    </section>
    
    <!-- SECTION 2: Activities -->
    <section class="activities">
        <div class="activities-header" style="display:flex;align-items:center;gap:14px;width:100%;max-width:1100px;margin:0 auto;">
            <div>
                <h2 class="section-title">Activities</h2>
                <p class="section-subtitle" style="margin:6px 0 0 0;">Explore our programs — tap a card for details.</p>
            </div>

            <div class="view-toggle" style="margin-left:auto;">
                <button id="layoutToggle" class="nav-btn nav-btn-register" aria-pressed="false" aria-label="Toggle activity layout">Switch to list</button>
            </div>
        </div>
        
        <div class="activity-grid">
            <div class="activity-card" role="button" tabindex="0" aria-pressed="false" aria-label="Art & Crafts details">
                <div class="activity-card-inner">
                    <div class="card-front">
                        <span class="activity-badge">Popular</span>
                        <div class="activity-icon-wrap" aria-hidden="true">
                            <svg class="activity-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Art icon">
                                <path fill="#ff6b6b" d="M2 21c0 .6.4 1 1 1h3l7-7-4-4L2 17v4z" />
                                <path fill="#1b4965" d="M14.3 8.7l1-1 4 4-1 1z" />
                            </svg>
                        </div> 
                        <h3 class="activity-title">Art & Crafts</h3>
                        <p class="activity-lead muted-text">Hands-on creative play and simple projects.</p>
                    </div>

                    <div class="card-back card-back-art">
                        <h3>What You'll Create</h3>
                        <ul>
                            <li>Finger painting</li>
                            <li>Paper craft animals</li>
                            <li>Colorful collages</li>
                        </ul>
                        <div class="testimonial-actions">
                            <a href="#" class="btn-small">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="activity-card" role="button" tabindex="0" aria-pressed="false" aria-label="Story Time details">
                <div class="activity-card-inner">
                    <div class="card-front">
                        <div class="activity-icon-wrap" aria-hidden="true">
                            <svg class="activity-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Book icon">
                                <path fill="#1b4965" d="M3 6v12a1 1 0 0 0 1 1h12V6H4a1 1 0 0 0-1 0z" />
                                <path fill="#ff6b6b" d="M21 6v11a1 1 0 0 1-1 1H9V6h11z" />
                            </svg>
                        </div> 
                        <h3 class="activity-title">Story Time</h3>
                        <p class="activity-lead muted-text">Interactive reading and puppetry to spark imagination.</p>
                    </div>
                    <div class="card-back card-back-story">
                        <h3>Magical Stories</h3>
                        <ul>
                            <li>Fairy tales</li>
                            <li>Interactive stories</li>
                            <li>Puppet shows</li>
                        </ul>
                        <div class="testimonial-actions">
                            <a href="#" class="btn-small">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="activity-card" role="button" tabindex="0" aria-pressed="false" aria-label="Music & Dance details">
                <div class="activity-card-inner">
                    <div class="card-front">
                        <div class="activity-icon-wrap" aria-hidden="true">
                            <svg class="activity-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Music icon">
                                <path fill="#ff6b6b" d="M9 17V5l10-2v12" />
                                <circle fill="#1b4965" cx="7" cy="17" r="2" />
                            </svg>
                        </div> 
                        <h3 class="activity-title">Music & Dance</h3>
                        <p class="activity-lead muted-text">Sing-along and movement to build confidence.</p>
                    </div>
                    <div class="card-back card-back-music">
                        <h3>Get Moving</h3>
                        <ul>
                            <li>Sing-along sessions</li>
                            <li>Dance parties</li>
                            <li>Instruments</li>
                        </ul>
                        <div class="testimonial-actions">
                            <a href="#" class="btn-small">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="activity-card" role="button" tabindex="0" aria-pressed="false" aria-label="Outdoor Play details">
                <div class="activity-card-inner">
                    <div class="card-front">
                        <div class="activity-icon-wrap" aria-hidden="true">
                            <svg class="activity-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Outdoor icon">
                                <path fill="#1b4965" d="M4 20h16v2H4z" />
                                <circle fill="#ff6b6b" cx="8" cy="8" r="2" />
                                <path fill="#ff6b6b" d="M12 4v12" />
                            </svg>
                        </div> 
                        <h3 class="activity-title">Outdoor Play</h3>
                        <p class="activity-lead muted-text">Playground, nature walks, and group games.</p>
                    </div>
                    <div class="card-back card-back-play">
                        <h3>Outside Fun</h3>
                        <ul>
                            <li>Playground</li>
                            <li>Nature walks</li>
                            <li>Sports games</li>
                        </ul>
                        <div class="testimonial-actions">
                            <a href="#" class="btn-small">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- SECTION 3: Game -->
    <section class="game-section">
        <div class="game-container">
            <h2 class="game-title">🎮 Catch the Stars!</h2>
            <p class="game-instructions">Click the stars as fast as you can!</p>
            <div class="catch-game" id="catchGame"></div>
            <p class="game-score">Score: <span id="score">0</span> ⭐</p>
        </div>
    </section>
    
    <!-- SECTION 4: Testimonials -->
    <section class="testimonials">
        <h2 class="section-title" style="margin-bottom: 50px;">💖 Happy Parents</h2>

        <div class="testimonial-marquee">
            <div class="testimonial-track">

                <!-- ORIGINAL SET -->
                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1542037104857-ffbb0b9155fb?q=80&w=1954&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Maria's Family">
                    </div>

                    <p class="testimonial-text">"My daughter can't wait to go to school every day!"</p>
                    <p class="testimonial-name">- Maria & Family</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1588979355313-6711a095465f?q=80&w=972&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Juan's Family">
                    </div>
                    <p class="testimonial-text">"The teachers are amazing and truly care!"</p>
                    <p class="testimonial-name">- Juan's Parents</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1559734840-f9509ee5677f?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Garcia's Family">
                    </div>
                    <p class="testimonial-text">"Best decision we ever made for our kids!"</p>
                    <p class="testimonial-name">- The Garcia Family</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1529518152792-d08317b26e22?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Santos's Family">
                    </div>
                    <p class="testimonial-text">"Safe, fun, and educational!"</p>
                    <p class="testimonial-name">- The Santos Family</p>
                </div>

                <!-- DUPLICATE SET (exact same order) -->
                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1542037104857-ffbb0b9155fb?q=80&w=1954&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Maria's Family">
                    </div>
                    <p class="testimonial-text">"My daughter can't wait to go to school every day!"</p>
                    <p class="testimonial-name">- Maria & Family</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1588979355313-6711a095465f?q=80&w=972&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Juan's Family">
                    </div>
                    <p class="testimonial-text">"The teachers are amazing and truly care!"</p>
                    <p class="testimonial-name">- Juan's Parents</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1559734840-f9509ee5677f?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Garcia's Family">
                    </div>
                    <p class="testimonial-text">"Best decision we ever made for our kids!"</p>
                    <p class="testimonial-name">- The Garcia Family</p>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-avatar-wrap">
                        <img src="https://images.unsplash.com/photo-1529518152792-d08317b26e22?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Santos's Family">
                    </div>
                    <p class="testimonial-text">"Safe, fun, and educational!"</p>
                    <p class="testimonial-name">- The Santos Family</p>
                </div>

            </div>
        </div>
    </section>

    
    <!-- SECTION 5: CTA -->
    <section class="cta-section">
        <div class="cta-stars" id="ctaStars"></div>
        <div class="cta-content">
            <h2>Ready for an Adventure? 🚀</h2>
            <p>Join Little Stars and watch your child shine!</p>
            <a href="{{ route('register') }}" class="btn-primary text-2xl py-5 px-10">Enroll now</a>
            <p class="footer-text" style="margin-top:28px;">© {{ date('Y') }} Little Stars Daycare</p>
        </div>
    </section>

    <!-- SITE FOOTER -->
    <footer class="site-footer">
        <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 240px;gap:30px;align-items:flex-start;">
            <div>
                <h3 style="font-family: 'Fredoka One', cursive; color: white; margin-bottom:8px;">Little Stars</h3>
                <p style="color: rgba(255,255,255,0.8); max-width:600px;">We provide a safe, caring, and imaginative space for early childhood development. Contact us for visits and enrollment information.</p>
                <p style="margin-top:12px; color: rgba(255,255,255,0.85);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:6px;color:var(--color-accent);"><path d="M6.6 10.2a15.05 15.05 0 006.2 6.2l2.2-2.2a1 1 0 01.9-.3c1 .2 2 .3 2.8.3a1 1 0 011 1v3a1 1 0 01-1 1C10.9 20.7 3.3 13.1 3.3 4a1 1 0 011-1h3a1 1 0 011 1c0 .9.1 1.8.3 2.7.1.4 0 .9-.3 1.2l-2 2z" fill="currentColor"/></svg>
                    <a href="tel:+1234567890">+1 (234) 567-890</a> • 
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:6px;color:var(--color-accent);"><path d="M3 6.5v11A2.5 2.5 0 005.5 20h13a2.5 2.5 0 002.5-2.5v-11A2.5 2.5 0 0018.5 4h-13A2.5 2.5 0 003 6.5z" stroke="currentColor" stroke-width="1.2" fill="none"/></svg>
                    <a href="mailto:hello@littlestars.example">hello@littlestars.example</a>
                </p> 
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;">
                <div>
                    <a class="btn-primary" href="{{ route('register') }}">Enroll now</a>
                </div>
                <div style="margin-top:8px; color: rgba(255,255,255,0.7); font-size:0.95rem;">Staff portal: <a href="{{ route('login') }}">Sign in</a></div>
                <div style="margin-top:18px; color: rgba(255,255,255,0.7); font-size:0.85rem;">Made with care in our community.</div>
            </div>
        </div>
    </footer>
    
    <script>
        // Generate stars for CTA section
        const ctaStars = document.getElementById('ctaStars');
        for (let i = 0; i < 30; i++) {
            const star = document.createElement('span');
            star.className = 'cta-star';
            star.textContent = '⭐';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            ctaStars.appendChild(star);
        }
        
        // Lightweight confetti - only on mascot click
        const canvas = document.getElementById('confetti-canvas');
        const ctx = canvas.getContext('2d');
        let confetti = [];
        const MAX_CONFETTI = 30;
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        class Confetto {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.size = Math.random() * 12 + 8;
                this.speedX = (Math.random() - 0.5) * 12;
                this.speedY = Math.random() * -12 - 5;
                this.gravity = 0.4;
                this.rotation = Math.random() * 360;
                this.rotationSpeed = (Math.random() - 0.5) * 8;
                this.emoji = ['⭐', '🌟', '✨', '💖'][Math.floor(Math.random() * 4)];
            }
            
            update() {
                this.speedY += this.gravity;
                this.x += this.speedX;
                this.y += this.speedY;
                this.rotation += this.rotationSpeed;
            }
            
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation * Math.PI / 180);
                ctx.font = this.size + 'px Arial';
                ctx.fillText(this.emoji, 0, 0);
                ctx.restore();
            }
        }
        
        function triggerConfetti(x, y) {
            const toAdd = Math.min(8, MAX_CONFETTI - confetti.length);
            for (let i = 0; i < toAdd; i++) {
                confetti.push(new Confetto(x, y));
            }
        }
        
        function animateConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            confetti = confetti.filter(c => c.y < canvas.height + 50);
            confetti.forEach(c => { c.update(); c.draw(); });
            requestAnimationFrame(animateConfetti);
        }
        animateConfetti();
        
        // Mascot interaction
        const mascots = ['🧸', '🐰', '🦁', '🐱', '🐶', '🦊', '🐼', '🐨'];
        let mascotIndex = 0;
        const speeches = ["Tap me for a surprise!", "Let's explore together.", "Ready to learn?"];
        
        function mascotClick() {
            mascotIndex = (mascotIndex + 1) % mascots.length;
            document.getElementById('mascot').textContent = mascots[mascotIndex];
            document.getElementById('speech').textContent = speeches[Math.floor(Math.random() * speeches.length)];
            document.getElementById('speech').style.opacity = 1;
            
            const rect = document.getElementById('mascot').getBoundingClientRect();
            triggerConfetti(rect.left + rect.width / 2, rect.top);
            
            setTimeout(() => { document.getElementById('speech').style.opacity = 0; }, 2000);
        }
        
        // Enable keyboard activation for mascot (Enter / Space)
        const mascotEl = document.getElementById('mascot');
        if (mascotEl) {
            mascotEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    mascotClick();
                }
            });
        }
        
        // Star catching game
        let score = 0;
        const gameArea = document.getElementById('catchGame');
        const emojis = ['⭐', '🌟', '💫', '✨'];
        
        function spawnStar() {
            if (!gameArea) return;
            const star = document.createElement('div');
            star.className = 'catch-item';
            star.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            star.style.left = Math.random() * (gameArea.offsetWidth - 50) + 'px';
            star.style.top = '-50px';
            gameArea.appendChild(star);
            
            star.addEventListener('click', () => {
                score++;
                document.getElementById('score').textContent = score;
                star.style.transform = 'scale(2)';
                star.style.opacity = '0';
                setTimeout(() => star.remove(), 150);
            });
            
            let posY = -50;
            const fall = setInterval(() => {
                posY += 2.5;
                star.style.top = posY + 'px';
                if (posY > gameArea.offsetHeight) {
                    clearInterval(fall);
                    star.remove();
                }
            }, 30);
        }
        
        setInterval(spawnStar, 1200);
        
        // Simple, accessible section navigation
        const sections = document.querySelectorAll('section');
        let currentSection = Array.from(sections).findIndex(s => Math.abs(s.getBoundingClientRect().top) < 50);
        if (currentSection === -1) currentSection = 0;
        
        function scrollToSection(index) {
            if (index < 0 || index >= sections.length) return;
            sections[index].scrollIntoView({ behavior: 'smooth' });
            currentSection = index;
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                e.preventDefault();
                scrollToSection(Math.min(currentSection + 1, sections.length - 1));
            } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                e.preventDefault();
                scrollToSection(Math.max(currentSection - 1, 0));
            }
        });

        // Activity card interactions — click or keyboard toggles flip; hover only pops up
        document.querySelectorAll('.activity-card').forEach(card => {
            // Toggle flip on click (ignore clicks on links inside the card)
            card.addEventListener('click', (e) => {
                if (e.target.closest('a')) return;
                card.classList.toggle('flipped');
                card.setAttribute('aria-pressed', card.classList.contains('flipped'));
            });

            // Keyboard support (Enter / Space to toggle, Escape to close)
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.classList.toggle('flipped');
                    card.setAttribute('aria-pressed', card.classList.contains('flipped'));
                } else if (e.key === 'Escape' && card.classList.contains('flipped')) {
                    card.classList.remove('flipped');
                    card.setAttribute('aria-pressed', 'false');
                }
            });
        });

        // Testimonial interactions — toggle expanded state on click/keyboard
        document.querySelectorAll('.testimonial-card').forEach(card => {
            card.addEventListener('click', () => {
                card.classList.toggle('expanded');
            });
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.classList.toggle('expanded');
                }
            });
        });

        // Layout toggle for activities (persist in localStorage)
        (function() {
            const toggle = document.getElementById('layoutToggle');
            const grid = document.querySelector('.activity-grid');
            if (!toggle || !grid) return;

            function applyLayout(mode) {
                if (mode === 'list') {
                    grid.classList.add('list-view');
                    toggle.textContent = 'Switch to grid';
                    toggle.setAttribute('aria-pressed', 'true');
                } else {
                    grid.classList.remove('list-view');
                    toggle.textContent = 'Switch to list';
                    toggle.setAttribute('aria-pressed', 'false');
                }
            }

            // Restore saved preference
            const saved = localStorage.getItem('activityLayout');
            if (saved === 'list') applyLayout('list');

            toggle.addEventListener('click', () => {
                const isList = grid.classList.toggle('list-view');
                applyLayout(isList ? 'list' : 'grid');
                localStorage.setItem('activityLayout', isList ? 'list' : 'grid');
            });
        })();
    </script>
</body>
</html>
