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
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }
        
        /* ========== SECTION 1: HERO ========== */
        .hero {
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sky {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        /* Day sky */
        .day-sky {
            background: linear-gradient(
                180deg,
                #87cefa,
                #b8e7ff
            );
            clip-path: polygon(0 0, 55% 0, 45% 100%, 0 100%);
            transition: clip-path 0.5s ease;
        }

        /* Night sky */
        .night-sky {
            background: linear-gradient(
                180deg,
                #2c2c54,
                #0c1445
            );
            clip-path: polygon(55% 0, 100% 0, 100% 100%, 45% 100%);
            transition: clip-path 0.5s ease;
        }

        /* Dark mode styles */
        body.dark-mode .day-sky {
            clip-path: polygon(0 0, 0 0, 0 100%, 0 100%);
        }
        
        body.dark-mode .night-sky {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
        
        /* Light mode styles */
        body.light-mode .day-sky {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }
        
        body.light-mode .night-sky {
            clip-path: polygon(100% 0, 100% 0, 100% 100%, 100% 100%);
        }


        
        /* Animated clouds */
       .cloud {
            position: absolute;
            width: 180px;
            height: 60px;
            background: rgba(255,255,255,0.85);
            border-radius: 50px;
            filter: blur(2px);
            box-shadow:
                40px 10px 0 rgba(255,255,255,0.8),
                80px 0 0 rgba(255,255,255,0.75);
            z-index: 2;
        }

        .cloud-1 {
            top: 18%;
            left: 10%;
            transition: opacity 0.5s ease, transform 0.8s ease;
        }

        .cloud-2 {
            top: 28%;
            left: 28%;
            transform: scale(0.8);
            transition: opacity 0.5s ease, transform 0.8s ease;
        }

        body.dark-mode .cloud-1,
        body.dark-mode .cloud-2 {
            opacity: 0;
            transform: translateX(-50px);
        }

        .birds {
            position: absolute;
            top: 22%;
            left: 22%;
            font-size: 22px;
            opacity: 0.6;
            z-index: 3;
            transition: opacity 0.5s ease;
        }
        
        body.dark-mode .birds {
            opacity: 0;
        }


        
        @keyframes cloudMove { 0% { left: -250px; } 100% { left: 110%; } }
        
        /* Sun */
        .sun {
            position: absolute;
            top: 14%;
            left: 18%;
            width: 80px;
            height: 80px;
            background-color: #FFD93B; /* bright yellow */
            border-radius: 50%;
            box-shadow:
                0 0 30px 10px #FFD93B,
                0 0 50px 20px #FFB74D,
                0 0 70px 30px #FF8A65; /* glow layers */
            z-index: 3;
            animation: sunGlow 3s infinite alternate;
            transition: opacity 0.5s ease, transform 0.8s ease;
        }

        @keyframes sunGlow {
            0% { box-shadow: 0 0 30px 10px #FFD93B, 0 0 50px 20px #FFB74D, 0 0 70px 30px #FF8A65; }
            100% { box-shadow: 0 0 40px 15px #FFD93B, 0 0 60px 25px #FFB74D, 0 0 80px 35px #FF8A65; }
        }

        body.dark-mode .sun {
            opacity: 0;
            transform: translateX(-50px) translateY(-50px);
        }

        .moon {
            position: absolute;
            top: 14%;
            right: 18%;
            width: 100px;
            height: 100px;
            background-color: transparent;
            border-radius: 50%;
            box-shadow: 25px 10px 0px 0px #d6cbb8;
            opacity: 0.9;
            z-index: 3;
            transition: opacity 0.5s ease, transform 0.8s ease;
        }

        body.light-mode .moon {
            opacity: 0;
            transform: translateX(50px) translateY(-50px);
        }

        .stars {
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            background:
                radial-gradient(white 1px, transparent 2px),
                radial-gradient(white 1px, transparent 2px);
            background-size: 80px 80px, 120px 120px;
            opacity: 0.4;
            z-index: 1;
            transition: opacity 0.5s ease, width 0.5s ease;
        }
        
        body.light-mode .stars {
            opacity: 0;
        }
        
        body.dark-mode .stars {
            width: 100%;
        }

        /* .ground {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(
                180deg,
                #6ab04c,
                #2ecc71
            );
            border-top-left-radius: 50% 40px;
            border-top-right-radius: 50% 40px;
            z-index: 4;
        } */

        
        @keyframes sunPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        /* Ground */
        /* .ground {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 180px;
            background: linear-gradient(180deg, #55efc4 0%, #00b894 50%, #00a085 100%);
        } */
        
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
        .nav-btn-toggle { 
            background: linear-gradient(135deg, #FFD93B, #0c1445); 
            color: white; 
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 15px 20px;
        }
        .toggle-icon {
            font-size: 1.2rem;
        }
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

        .activities::before {
            content: '🎈 ⭐ 🖍️ 🌈 🧩';
            position: absolute;
            font-size: 80px;
            opacity: 0.08;
            top: 10%;
            left: 5%;
            transform: rotate(-10deg);
            pointer-events: none;
        }

        .game-section::before,
        .game-section::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 90px;
            background: #ffffff;
            border-radius: 100px;
            opacity: 0.75;
            pointer-events: none;
            filter: blur(0.5px);
        }

        .game-section::before {
            top: 12%;
            left: -120px;
            box-shadow:
                60px 10px 0 10px #fff,
                120px -10px 0 15px #fff,
                180px 5px 0 5px #fff;
            animation: cloudMove 60s linear infinite;
        }

        .game-section::after {
            top: 38%;
            left: -160px;
            width: 360px;
            height: 110px;
            opacity: 0.6;
            box-shadow:
                80px 20px 0 12px #fff,
                160px -12px 0 18px #fff,
                240px 10px 0 6px #fff;
            animation: cloudMove 90s linear infinite;
        }

        .mountain, .mountain-two, .mountain-three, .mountain-four, .mountain-five {
            position: absolute;
            bottom: 0;
            border-left: 150px solid transparent;
            border-right: 150px solid transparent;
            border-bottom: 180px solid #7ac1e4;
            z-index: 1;
        }
        .mountain-two { 
            left: 80px;
            bottom: -20px;
            opacity: .3;
            z-index: 0;
        }
        .mountain-three {
            left: -60px;
            bottom:-10px;
            opacity: .5;
            z-index: 0;
        }
        .mountain-four {
            left: 1180px;
            bottom: -20px;
            opacity: .5;
            z-index: 0;
        }
        .mountain-five {
            left: 1350px;
            bottom: -10px;
            opacity: .5;
            z-index: 0;
        }
        .mountain-top {
            position: absolute;
            right: -65px;
            border-left: 65px solid transparent;
            border-right: 65px solid transparent;
            border-bottom: 77px solid #ceeaf6;
            z-index: 2;
        }
        .mountain-cap-1, .mountain-cap-2, .mountain-cap-3 {
            position: absolute;
            top: 70px;
            border-left: 25px solid transparent;
            border-right: 25px solid transparent;
            border-top: 25px solid #ceeaf6;
        }
        .mountain-cap-1 { left: -55px; }
        .mountain-cap-2 { left: -25px; }
        .mountain-cap-3 { left: 5px; }
        .cloud, .cloud:before, .cloud:after {
        position: absolute;
        width: 70px;
            height: 30px;
            background: #fff;
            -webkit-border-radius: 100px / 50px;
            border-radius: 100px / 50px;
        }
        .cloud { 
        bottom: 100px;
        -webkit-animation: cloud 50s infinite linear;
                animation: cloud 50s infinite linear;
        }
        @-webkit-keyframes cloud {
            0%   { left: -100px; }
            100% { left: 1000px; } 
        }
        @keyframes cloud {
        
            0%   { left: -100px; }
            100% { left: 1000px; } 
        }
        .cloud:before {
        content: '';
        left: 50px;
        }
        .cloud:after {
        content: '';
        left: 25px;
        top: -10px;
        }

        @keyframes cloudMove {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(120vw);
            }
        }



        @keyframes floaty {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
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
        .site-footer { 
            background: linear-gradient(180deg, #a29bfe 0%, #6c5ce7 100%);
            color: rgba(255,255,255,0.92); 
            padding: 48px 20px 20px; 
            position: relative;
            overflow: hidden;
            border-top: 12px solid #fd79a8;
            border-top-left-radius: 40% 30px;
            border-top-right-radius: 40% 30px;
        }
        
        .site-footer::before {
            content: "👶 🎈 🎨 🎵 🎮";
            position: absolute;
            top: 10px;
            left: 0;
            width: 100%;
            font-size: 20px;
            opacity: 0.2;
            display: flex;
            justify-content: space-around;
            transform: translateY(-50%);
            pointer-events: none;
        }
        
        .site-footer a { 
            color: #fff; 
            text-decoration: none; 
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .site-footer a:hover {
            color: #FFD93B;
            transform: scale(1.05);
        }
        
        .site-footer .col { min-width: 200px; }
        
        .footer-heading {
            font-family: 'Fredoka One', cursive; 
            color: #fff; 
            margin-bottom: 15px;
            font-size: 1.8rem;
            text-shadow: 2px 2px 0 rgba(0,0,0,0.1);
        }
        
        .footer-text {
            color: rgba(255,255,255,0.9);
            line-height: 1.6;
            font-size: 1.05rem;
        }
        
        .footer-contact {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 15px 20px;
            margin-top: 15px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .footer-bubble {
            position: absolute;
            bottom: -20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: bubbleFloat 8s infinite ease-in-out;
        }
        
        .footer-bubble:nth-child(1) {
            left: 10%;
            width: 30px;
            height: 30px;
            animation-delay: 0s;
        }
        
        .footer-bubble:nth-child(2) {
            left: 30%;
            width: 25px;
            height: 25px;
            animation-delay: 2s;
        }
        
        .footer-bubble:nth-child(3) {
            left: 50%;
            width: 35px;
            height: 35px;
            animation-delay: 4s;
        }
        
        .footer-bubble:nth-child(4) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 6s;
        }
        
        .footer-bubble:nth-child(5) {
            left: 90%;
            width: 30px;
            height: 30px;
            animation-delay: 8s;
        }
        
        @keyframes bubbleFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-40px);
            }
        }
        
        .copyright {
            font-family: 'Nunito', sans-serif;
            background: rgba(0, 0, 0, 0.1);
            padding: 15px;
            border-radius: 30px;
            margin-top: 25px;
            text-align: center;
            font-size: 0.9rem;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 992px) {
            .testimonial-grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
        }
        @media (max-width: 640px) {
            .testimonial-grid { grid-template-columns: 1fr; }
            .activity-card { width: 90%; transform: none; }
        }

        /* ========== SECTION 3: GAME ========== */
        .game-section {
            position: relative;
            padding: 90px 20px;
            overflow: hidden;

            background:
                radial-gradient(circle at 15% 20%, rgba(255,255,255,0.8) 0 60px, transparent 61px),
                radial-gradient(circle at 80% 30%, rgba(255,255,255,0.7) 0 80px, transparent 81px),
                radial-gradient(circle at 40% 75%, rgba(255,255,255,0.6) 0 70px, transparent 71px),
                linear-gradient(180deg, #c7ecee 0%, #a29bfe 45%, #74b9ff 100%);
        }

        
        .game-container {
            max-width: 700px;
            width: 92%;
            background: linear-gradient(180deg, #ffffff, #fffdf3);
            border-radius: 48px;
            padding: 40px;
            box-shadow:
                0 30px 70px rgba(0,0,0,0.18),
                inset 0 6px 0 rgba(255,255,255,0.7);
            border: 6px dashed rgb(156 26 184 / 60%);
            position: relative;
        }

        
        .game-title { font-family: 'Fredoka One', cursive; font-size: 2.2rem; color: #e17055; margin-bottom: 20px; text-align: center; }
        
        .catch-game {
            height: 260px;
            background:
                radial-gradient(circle at 20% 30%, #ffffff 0 18px, transparent 19px),
                radial-gradient(circle at 70% 40%, #ffffff 0 22px, transparent 23px),
                linear-gradient(180deg, #a29bfe, #74b9ff);
            border-radius: 28px;
            position: relative;
            overflow: hidden;
            cursor: crosshair;
            margin-bottom: 20px;
            box-shadow: inset 0 -10px 0 rgba(0,0,0,0.08);
        }

        
        .catch-item {
            position: absolute;
            font-size: 46px;
            cursor: pointer;
            user-select: none;
            animation: pop 1.4s ease-in-out infinite;
        }

        @keyframes pop {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.25) rotate(8deg); }
        }

        .catch-item:hover { transform: scale(1.3); }
        
        .game-score { font-size: 1.3rem; font-weight: 800; color: #6c5ce7; text-align: center; }
        .game-instructions { color: #666; margin-bottom: 15px; font-size: 1.1rem; text-align: center; }
        
        /* ========== SECTION 4: TESTIMONIALS ========== */
        .testimonials {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 70%, #6c5ce7 100%);
            padding: 60px 20px;
            position: relative;
            overflow: hidden;
        }
        
        /* Rainbow border top */
        .testimonials::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 12px;
            background: linear-gradient(
                to right,
                #ff6b6b 0%,
                #feca57 16.6%, 
                #1dd1a1 33.2%, 
                #00d2d3 49.8%, 
                #54a0ff 66.4%, 
                #5f27cd 83%,
                #8854d0 100%
            );
            z-index: 5;
        }
        
        /* Emoji row */
        .testimonials::after {
            content: "🎈 🚀 🌟 🎮 🦄 🎨 📚 🎵 🧩";
            position: absolute;
            top: 20px;
            left: 0;
            width: 100%;
            font-size: 22px;
            opacity: 0.2;
            display: flex;
            justify-content: space-around;
            pointer-events: none;
            z-index: 1;
        }
        
        /* Bouncing decorations */
        .testimonial-decoration {
            position: absolute;
            z-index: 1;
            pointer-events: none;
            animation: bounce 3s infinite alternate ease-in-out;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .testimonial-decoration-1 {
            top: 15%;
            left: 5%;
            font-size: 60px;
            opacity: 0.25;
            animation-duration: 4s;
        }
        
        .testimonial-decoration-2 {
            top: 25%;
            right: 8%;
            font-size: 50px;
            opacity: 0.2;
            animation-duration: 5s;
            animation-delay: 1s;
        }
        
        .testimonial-decoration-3 {
            bottom: 20%;
            left: 10%;
            font-size: 55px;
            opacity: 0.25;
            animation-duration: 3.5s;
            animation-delay: 0.5s;
        }
        
        .testimonial-decoration-4 {
            bottom: 30%;
            right: 12%;
            font-size: 45px;
            opacity: 0.2;
            animation-duration: 4.5s;
            animation-delay: 1.5s;
        }
        
        .testimonial-decoration-5 {
            top: 40%;
            left: 20%;
            font-size: 48px;
            opacity: 0.15;
            animation-duration: 6s;
        }
        
        /* Cloud patterns */
        .cloud-shape {
            position: absolute;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            z-index: 0;
        }
        
        .cloud-shape::before,
        .cloud-shape::after {
            content: '';
            position: absolute;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }
        
        .cloud-shape-1 {
            width: 200px;
            height: 60px;
            top: 10%;
            left: -30px;
        }
        
        .cloud-shape-1::before {
            width: 80px;
            height: 80px;
            top: -40px;
            left: 30px;
        }
        
        .cloud-shape-1::after {
            width: 60px;
            height: 60px;
            top: -30px;
            left: 100px;
        }
        
        .cloud-shape-2 {
            width: 180px;
            height: 50px;
            bottom: 15%;
            right: -40px;
        }
        
        .cloud-shape-2::before {
            width: 70px;
            height: 70px;
            top: -30px;
            right: 40px;
        }
        
        .cloud-shape-2::after {
            width: 50px;
            height: 50px;
            top: -25px;
            right: 100px;
        }
        
        /* Rainbow stripe */
        .rainbow-stripe {
            position: absolute;
            height: 30px;
            width: 100%;
            left: 0;
            background: linear-gradient(
                to right,
                #ff6b6b 0%,
                #feca57 16.6%, 
                #1dd1a1 33.2%, 
                #00d2d3 49.8%, 
                #54a0ff 66.4%, 
                #8854d0 100%
            );
            opacity: 0.15;
            z-index: 0;
        }
        
        .rainbow-stripe-1 {
            bottom: 40%;
            transform: rotate(-2deg);
        }
        
        .rainbow-stripe-2 {
            top: 30%;
            transform: rotate(3deg);
        }
        
        /* Zigzag pattern */
        .zigzag {
            position: absolute;
            height: 12px;
            width: 100%;
            background: 
                linear-gradient(135deg, rgba(255,255,255,0.15) 25%, transparent 25%) -10px 0,
                linear-gradient(225deg, rgba(255,255,255,0.15) 25%, transparent 25%) -10px 0,
                linear-gradient(315deg, rgba(255,255,255,0.15) 25%, transparent 25%),
                linear-gradient(45deg, rgba(255,255,255,0.15) 25%, transparent 25%);
            background-size: 20px 20px;
            z-index: 0;
        }
        
        .zigzag-1 {
            bottom: 10%;
        }
        
        .zigzag-2 {
            top: 15%;
        }
        
        .testimonial-track {
            display: flex;
            animation: scroll 25s linear infinite;
            width: max-content;
        }
        
        .testimonial-track:hover { animation-play-state: paused; }
        
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        
        .testimonial-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            margin: 0 15px;
            min-width: 320px;
            box-shadow: 
                0 15px 40px rgba(0,0,0,0.2),
                inset 0 -5px 0 rgba(108,92,231,0.4),
                inset 0 5px 0 rgba(253,121,168,0.4);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 3px solid rgba(255,255,255,0.8);
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 
                0 20px 50px rgba(0,0,0,0.3),
                inset 0 -8px 0 rgba(108,92,231,0.6),
                inset 0 8px 0 rgba(253,121,168,0.6);
            border-color: white;
        }
        
        .testimonial-avatar { font-size: 60px; margin-bottom: 15px; }
        .testimonial-text { font-size: 1rem; color: #666; line-height: 1.7; margin-bottom: 15px; }
        .testimonial-name { font-weight: 800; color: #6c5ce7; font-size: 1.1rem; }
        
        /* Testimonial Modal */
        .testimonial-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .testimonial-modal {
            background: white;
            width: 90%;
            max-width: 600px;
            border-radius: 30px;
            padding: 40px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            transform: scale(0.9);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
        }
        
        .testimonial-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .testimonial-modal-overlay.active .testimonial-modal {
            transform: scale(1);
            opacity: 1;
        }
        
        .testimonial-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #e84393;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        
        .testimonial-modal-close:hover {
            background-color: rgba(232, 67, 147, 0.1);
        }
        
        .modal-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed rgba(108, 92, 231, 0.2);
            padding-bottom: 20px;
        }
        
        .modal-avatar-wrap {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            padding: 6px;
            background: linear-gradient(135deg, #fd79a8, #6c5ce7);
        }
        
        .modal-avatar-wrap img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .modal-name {
            font-family: 'Fredoka One', cursive;
            font-size: 1.8rem;
            color: #6c5ce7;
            margin: 0;
        }
        
        .modal-title {
            font-size: 1rem;
            color: #fd79a8;
            margin-top: 5px;
        }
        
        .modal-content {
            color: #4b5563;
            line-height: 1.7;
        }
        
        .modal-quote {
            font-size: 1.1rem;
            font-style: italic;
            color: #2d3748;
            border-left: 4px solid #6c5ce7;
            padding-left: 15px;
            margin: 20px 0;
        }
        
        .modal-children-info {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed rgba(108, 92, 231, 0.2);
        }
        
        .child-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: linear-gradient(135deg, #fd79a8, #6c5ce7);
            border-radius: 50%;
            color: white;
            font-size: 20px;
            margin-right: 10px;
        }
        
        .stars-row {
            color: #FFD93B;
            font-size: 1.2rem;
            margin: 15px 0;
        }
        
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
        </a>
    </div>

    <!-- Floating Navigation -->
    <div class="nav-float">
        <button id="theme-toggle" class="nav-btn nav-btn-toggle" aria-label="Toggle light/dark theme">
            <span class="toggle-icon">☀️</span>
            <span class="toggle-icon">🌙</span>
        </button>
        
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
        <div class="sky day-sky"></div>
        <div class="sky night-sky"></div>

        <!-- Day elements -->
        <div class="sun"></div>
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>

        <!-- Night elements -->
        <div class="moon"></div>
        <div class="stars"></div>

        <div class="mountain">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-two">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-three">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-four">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-five">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="cloud"></div>

        <div class="hero-content">
            <h1 class="hero-title">Little Stars Daycare</h1>
            <p class="hero-subtitle">A safe, playful environment for early learning.</p>
        </div>

        <div class="mascot-container">
            <div class="speech-bubble" id="speech">Tap the mascot</div>
            <div class="mascot" id="mascot" onclick="mascotClick()">🧸</div>
        </div>

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
         <!-- Background scenery -->
        <div class="mountain">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-two">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-three">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-four">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="mountain-five">
            <div class="mountain-top">
                <div class="mountain-cap-1"></div>
                <div class="mountain-cap-2"></div>
                <div class="mountain-cap-3"></div>
            </div>
        </div>
        <div class="cloud"></div>
        <div class="game-container">
            <h2 class="game-title">🎮 Catch the Stars!</h2>
            <p class="game-instructions">Click the stars as fast as you can!</p>
            <div class="catch-game" id="catchGame"></div>
            <p class="game-score">Score: <span id="score">0</span> ⭐</p>
        </div>
    </section>
    
    <!-- SECTION 4: Testimonials -->
    <section class="testimonials">
        <!-- Decorative elements -->
        <div class="testimonial-decoration testimonial-decoration-1">🧸</div>
        <div class="testimonial-decoration testimonial-decoration-2">🎨</div>
        <div class="testimonial-decoration testimonial-decoration-3">🚂</div>
        <div class="testimonial-decoration testimonial-decoration-4">🎮</div>
        <div class="testimonial-decoration testimonial-decoration-5">🧩</div>
        
        <!-- Cloud shapes -->
        <div class="cloud-shape cloud-shape-1"></div>
        <div class="cloud-shape cloud-shape-2"></div>
        
        <!-- Rainbow stripes -->
        <div class="rainbow-stripe rainbow-stripe-1"></div>
        <div class="rainbow-stripe rainbow-stripe-2"></div>
        
        <!-- Zigzag patterns -->
        <div class="zigzag zigzag-1"></div>
        <div class="zigzag zigzag-2"></div>
        
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
    
    <!-- Testimonial Modal Container -->
    <div class="testimonial-modal-overlay" id="testimonial-modal-overlay">
        <div class="testimonial-modal">
            <button class="testimonial-modal-close" aria-label="Close modal">×</button>
            <div class="modal-header">
                <div class="modal-avatar-wrap">
                    <img src="" alt="" id="modal-avatar">
                </div>
                <h2 class="modal-name" id="modal-name"></h2>
                <p class="modal-title" id="modal-title"></p>
                <div class="stars-row" id="modal-stars"></div>
            </div>
            <div class="modal-content">
                <div class="modal-quote" id="modal-quote"></div>
                <p id="modal-full-testimonial"></p>
                <div class="modal-children-info" id="modal-children-info"></div>
            </div>
        </div>
    </div>
    
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
        <!-- Decorative bubbles -->
        <div class="footer-bubble"></div>
        <div class="footer-bubble"></div>
        <div class="footer-bubble"></div>
        <div class="footer-bubble"></div>
        <div class="footer-bubble"></div>
        
        <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 240px;gap:30px;align-items:flex-start;">
            <div>
                <h3 class="footer-heading">✨ Little Stars ✨</h3>
                <p class="footer-text">We provide a safe, caring, and imaginative space for early childhood development. Our colorful world is designed to inspire young minds!</p>
                
                <div class="footer-contact">
                    <p style="margin-bottom:10px; font-weight:bold;">Contact our friendly staff:</p>
                    <p style="margin:8px 0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:8px;color:#FFD93B;"><path d="M6.6 10.2a15.05 15.05 0 006.2 6.2l2.2-2.2a1 1 0 01.9-.3c1 .2 2 .3 2.8.3a1 1 0 011 1v3a1 1 0 01-1 1C10.9 20.7 3.3 13.1 3.3 4a1 1 0 011-1h3a1 1 0 011 1c0 .9.1 1.8.3 2.7.1.4 0 .9-.3 1.2l-2 2z" fill="currentColor"/></svg>
                        <a href="tel:+1234567890">+1 (234) 567-890</a>
                    </p>
                    <p style="margin:8px 0;"> 
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:8px;color:#FFD93B;"><path d="M3 6.5v11A2.5 2.5 0 005.5 20h13a2.5 2.5 0 002.5-2.5v-11A2.5 2.5 0 0018.5 4h-13A2.5 2.5 0 003 6.5z" stroke="currentColor" stroke-width="1.2" fill="none"/></svg>
                        <a href="mailto:hello@littlestars.example">hello@littlestars.example</a>
                    </p>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:2rem;align-items:flex-end;">
                <div>
                    <a class="nav-btn nav-btn-register" style="animation: float 3s ease-in-out infinite;" href="{{ route('register') }}">Join Our Family! 🚀</a>
                </div>
                <div style="padding:12px 18px; background:rgba(255,255,255,0.2); border-radius:20px; text-align:center;">
                    <div style="margin-bottom:8px; font-weight:bold;">Are you a teacher?</div>
                    <a href="{{ route('login') }}" style="display:inline-block; padding:8px 15px; background:#fff; color:#6c5ce7; border-radius:20px; font-weight:bold;">Staff Login</a>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            © {{ date('Y') }} Little Stars Daycare • Made with ❤️ for happy kids
        </div>
    </footer>
    
    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Check for saved theme preference or use device preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            body.classList.add(savedTheme + '-mode');
            updateThemeIcon(savedTheme);
        } else if (prefersDarkMode) {
            body.classList.add('dark-mode');
            updateThemeIcon('dark');
        } else {
            body.classList.add('light-mode');
            updateThemeIcon('light');
        }
        
        // Toggle theme when button is clicked
        themeToggle.addEventListener('click', () => {
            if (body.classList.contains('light-mode')) {
                body.classList.replace('light-mode', 'dark-mode');
                localStorage.setItem('theme', 'dark');
                updateThemeIcon('dark');
            } else {
                body.classList.replace('dark-mode', 'light-mode');
                localStorage.setItem('theme', 'light');
                updateThemeIcon('light');
            }
        });
        
        // Update button appearance based on current theme
        function updateThemeIcon(theme) {
            const icons = themeToggle.querySelectorAll('.toggle-icon');
            if (theme === 'dark') {
                icons[0].style.opacity = '0.3';
                icons[1].style.opacity = '1';
            } else {
                icons[0].style.opacity = '1';
                icons[1].style.opacity = '0.3';
            }
        }
        
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

        // Testimonial Modal Functionality
        const testimonialData = [
            {
                name: "Maria & Family",
                title: "Parents of Sofia, Age 4",
                stars: 5,
                avatar: "https://images.unsplash.com/photo-1542037104857-ffbb0b9155fb?q=80&w=1954&auto=format&fit=crop&ixlib=rb-4.1.0",
                quote: "My daughter can't wait to go to school every day!",
                fullTestimonial: "From the first day, Sofia has been excited to attend Little Stars Daycare. The teachers create such an engaging environment that she's always eager to tell us about the new things she learned. The art projects she brings home are beautiful, and we can see her confidence growing every day.",
                children: [
                    { name: "Sofia", age: 4, icon: "👧" }
                ]
            },
            {
                name: "Juan's Parents",
                title: "Parents of Juan, Age 3.5",
                stars: 5,
                avatar: "https://images.unsplash.com/photo-1588979355313-6711a095465f?q=80&w=972&auto=format&fit=crop&ixlib=rb-4.1.0",
                quote: "The teachers are amazing and truly care!",
                fullTestimonial: "We've tried several daycares before finding Little Stars, and the difference is remarkable. The teachers genuinely care about each child's development and well-being. They always take time to discuss Juan's progress with us and offer suggestions for activities we can do at home to support his learning.",
                children: [
                    { name: "Juan", age: 3.5, icon: "👦" }
                ]
            },
            {
                name: "The Garcia Family",
                title: "Parents of Twins Luis & Mia, Age 5",
                stars: 5,
                avatar: "https://images.unsplash.com/photo-1559734840-f9509ee5677f?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0",
                quote: "Best decision we ever made for our kids!",
                fullTestimonial: "Having twins can be challenging, but Little Stars has made it so much easier for us. The staff understands that while Luis and Mia are twins, they have different personalities and learning styles. They've helped both kids develop their unique strengths while ensuring they're both prepared for kindergarten next year.",
                children: [
                    { name: "Luis", age: 5, icon: "👦" },
                    { name: "Mia", age: 5, icon: "👧" }
                ]
            },
            {
                name: "The Santos Family",
                title: "Parents of Emma, Age 4",
                stars: 5,
                avatar: "https://images.unsplash.com/photo-1529518152792-d08317b26e22?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0",
                quote: "Safe, fun, and educational!",
                fullTestimonial: "Safety was our top concern when looking for a daycare, and Little Stars exceeds our expectations. The facility is always clean, secure, and well-maintained. Beyond that, Emma is learning so much through play and structured activities. She's already counting to 20 and writing her name!",
                children: [
                    { name: "Emma", age: 4, icon: "👧" }
                ]
            }
        ];
        
        // Modal elements
        const modalOverlay = document.getElementById('testimonial-modal-overlay');
        const modalClose = modalOverlay.querySelector('.testimonial-modal-close');
        const modalAvatar = document.getElementById('modal-avatar');
        const modalName = document.getElementById('modal-name');
        const modalTitle = document.getElementById('modal-title');
        const modalStars = document.getElementById('modal-stars');
        const modalQuote = document.getElementById('modal-quote');
        const modalFullTestimonial = document.getElementById('modal-full-testimonial');
        const modalChildrenInfo = document.getElementById('modal-children-info');
        
        // Open modal with testimonial data
        function openTestimonialModal(index) {
            const data = testimonialData[index % testimonialData.length];
            
            // Set modal content
            modalAvatar.src = data.avatar;
            modalAvatar.alt = data.name;
            modalName.textContent = data.name;
            modalTitle.textContent = data.title;
            
            // Set stars
            modalStars.innerHTML = '★'.repeat(data.stars) + '☆'.repeat(5 - data.stars);
            
            // Set quote and full testimonial
            modalQuote.textContent = `"${data.quote}"`;
            modalFullTestimonial.textContent = data.fullTestimonial;
            
            // Set children info
            modalChildrenInfo.innerHTML = '';
            if (data.children && data.children.length > 0) {
                const childrenHeading = document.createElement('h3');
                childrenHeading.textContent = 'Our Little Stars:';
                childrenHeading.style.marginBottom = '15px';
                childrenHeading.style.fontSize = '1.1rem';
                childrenHeading.style.color = '#6c5ce7';
                modalChildrenInfo.appendChild(childrenHeading);
                
                const childrenContainer = document.createElement('div');
                childrenContainer.style.display = 'flex';
                childrenContainer.style.flexWrap = 'wrap';
                childrenContainer.style.gap = '15px';
                
                data.children.forEach(child => {
                    const childDiv = document.createElement('div');
                    childDiv.style.display = 'flex';
                    childDiv.style.alignItems = 'center';
                    
                    const iconSpan = document.createElement('span');
                    iconSpan.className = 'child-icon';
                    iconSpan.textContent = child.icon;
                    
                    const infoSpan = document.createElement('span');
                    infoSpan.textContent = `${child.name}, ${child.age} years`;
                    
                    childDiv.appendChild(iconSpan);
                    childDiv.appendChild(infoSpan);
                    childrenContainer.appendChild(childDiv);
                });
                
                modalChildrenInfo.appendChild(childrenContainer);
            }
            
            // Show modal
            modalOverlay.classList.add('active');
            
            // Prevent body scrolling
            document.body.style.overflow = 'hidden';
        }
        
        // Close modal
        function closeTestimonialModal() {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Set up event listeners
        modalClose.addEventListener('click', closeTestimonialModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                closeTestimonialModal();
            }
        });
        
        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
                closeTestimonialModal();
            }
        });
        
        // Add click event to testimonial cards
        document.querySelectorAll('.testimonial-card').forEach((card, index) => {
            card.addEventListener('click', () => {
                openTestimonialModal(index % testimonialData.length);
            });
            
            // Keyboard support
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openTestimonialModal(index % testimonialData.length);
                }
            });
            
            // Make cards focusable
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            card.setAttribute('aria-label', `View full testimonial from ${testimonialData[index % testimonialData.length].name}`);
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
