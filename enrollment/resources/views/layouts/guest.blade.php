<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars Daycare') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        /* --- COLORS (matching homepage) --- */
        :root {
            --bg-cream: #FFFCF5;
            --bg-white: #FFFFFF;
            --c-blue: #3F9AAE;
            --c-teal: #79C9C5;
            --c-yellow: #FFE2AF;
            --c-coral: #F96E5B;
            --c-dark: #2D3748;
            --border-thick: 3px solid var(--c-dark);
            --shadow-hard: 5px 5px 0px 0px var(--c-dark);
        }

        /* --- RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--c-blue);
            color: var(--c-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3 { font-family: 'Fredoka', sans-serif; line-height: 1.1; letter-spacing: 0.01em; }
        a { text-decoration: none; color: inherit; transition: all 0.2s; }

        /* --- FLOATING BACKGROUND --- */
        .bg-shapes { position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
        .floating-shape { position: absolute; border-radius: 50%; opacity: 0.15; animation: floatShape 8s ease-in-out infinite; }
        .floating-shape.blob { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        .fs-1 { width: 120px; height: 120px; background: var(--c-coral); top: 10%; left: 5%; animation-delay: 0s; animation-duration: 7s; }
        .fs-2 { width: 80px; height: 80px; background: var(--c-teal); top: 60%; left: 8%; animation-delay: 1.5s; animation-duration: 9s; }
        .fs-3 { width: 150px; height: 150px; background: var(--c-yellow); top: 15%; right: 10%; animation-delay: 0.5s; animation-duration: 8s; }
        .fs-4 { width: 70px; height: 70px; background: white; top: 70%; right: 5%; animation-delay: 2s; animation-duration: 6s; }
        .fs-5 { width: 100px; height: 100px; background: var(--c-coral); bottom: 15%; left: 20%; animation-delay: 1s; animation-duration: 10s; }
        .fs-6 { width: 60px; height: 60px; background: white; bottom: 30%; right: 15%; animation-delay: 3s; animation-duration: 7s; }
        @keyframes floatShape { 
            0%, 100% { transform: translateY(0) rotate(0deg) scale(1); } 
            25% { transform: translateY(-20px) rotate(5deg) scale(1.05); } 
            50% { transform: translateY(-10px) rotate(-3deg) scale(0.98); } 
            75% { transform: translateY(-25px) rotate(8deg) scale(1.02); } 
        }

        /* --- AUTH CARD --- */
        .auth-wrapper { position: relative; z-index: 10; width: 100%; max-width: 440px; }
        
        .auth-card {
            background: var(--bg-white);
            border: var(--border-thick);
            border-radius: 28px;
            padding: 48px 40px;
            box-shadow: var(--shadow-hard);
            animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--c-blue);
            margin-bottom: 16px;
        }
        .auth-logo i { color: var(--c-coral); font-size: 1.8rem; transform: rotate(-10deg); }
        .auth-title { font-size: 2rem; color: var(--c-dark); margin-bottom: 8px; }
        .auth-subtitle { color: #666; font-weight: 500; font-size: 1rem; }

        /* --- FORM STYLES --- */
        .form-group { margin-bottom: 20px; }
        .form-label { 
            display: block; 
            font-weight: 700; 
            margin-bottom: 8px; 
            color: var(--c-dark); 
            font-size: 0.95rem;
        }
        .form-input {
            width: 100%;
            padding: 14px 18px;
            font-size: 1rem;
            font-family: inherit;
            border: var(--border-thick);
            border-radius: 14px;
            background: var(--bg-cream);
            color: var(--c-dark);
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            box-shadow: 4px 4px 0px var(--c-teal);
            transform: translate(-2px, -2px);
        }
        .form-input::placeholder { color: #999; }

        .error-message {
            color: var(--c-coral);
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 6px;
        }
        .status-message {
            background: var(--c-teal);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }

        /* --- REMEMBER / FORGOT ROW --- */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #555;
            cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--c-blue);
            cursor: pointer;
        }
        .forgot-link {
            font-weight: 700;
            color: var(--c-blue);
        }
        .forgot-link:hover { color: var(--c-coral); text-decoration: underline; }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 16px 32px;
            font-weight: 700;
            border-radius: 100px;
            border: var(--border-thick);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
            font-family: inherit;
        }
        .btn:hover { transform: translate(-4px, -4px); box-shadow: var(--shadow-hard); }
        .btn:active { transform: translate(0, 0); box-shadow: none; }
        .btn-primary { background-color: var(--c-coral); color: white; }
        .btn-secondary { background-color: var(--c-yellow); color: var(--c-dark); }

        /* --- FOOTER LINK --- */
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-weight: 600;
            color: #666;
        }
        .auth-footer a {
            color: var(--c-blue);
            font-weight: 700;
        }
        .auth-footer a:hover { color: var(--c-coral); text-decoration: underline; }

        /* --- BACK HOME LINK --- */
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
            color: white;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 50px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.2s;
        }
        .back-home:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 480px) {
            .auth-card { padding: 32px 24px; }
            .auth-title { font-size: 1.6rem; }
            .options-row { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <!-- Background floating shapes -->
    <div class="bg-shapes">
        <div class="floating-shape blob fs-1"></div>
        <div class="floating-shape blob fs-2"></div>
        <div class="floating-shape blob fs-3"></div>
        <div class="floating-shape blob fs-4"></div>
        <div class="floating-shape blob fs-5"></div>
        <div class="floating-shape blob fs-6"></div>
    </div>

    <div class="auth-wrapper">
        {{ $slot }}
        
        <div style="text-align: center;">
            <a href="{{ url('/') }}" class="back-home">
                <i class="ri-home-4-fill"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>
