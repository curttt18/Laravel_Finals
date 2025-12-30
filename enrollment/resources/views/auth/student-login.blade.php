<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Login - Little Stars</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --bg-cream: #FFFCF5;
            --c-blue: #3F9AAE;
            --c-teal: #79C9C5;
            --c-yellow: #FFE2AF;
            --c-coral: #F96E5B;
            --c-dark: #2D3748;
            --border-thick: 3px solid var(--c-dark);
            --shadow-hard: 5px 5px 0px 0px var(--c-dark);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #79C9C5 0%, #3F9AAE 50%, #FFE2AF 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            padding: 20px;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating shapes */
        .floating-shapes {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) { width: 80px; height: 80px; background: var(--c-coral); top: 10%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 60px; height: 60px; background: var(--c-yellow); top: 20%; right: 10%; animation-delay: 1s; }
        .shape:nth-child(3) { width: 100px; height: 100px; background: rgba(255,255,255,0.3); bottom: 20%; left: 5%; animation-delay: 2s; }
        .shape:nth-child(4) { width: 50px; height: 50px; background: var(--c-coral); bottom: 30%; right: 15%; animation-delay: 0.5s; }
        .shape:nth-child(5) { width: 70px; height: 70px; background: rgba(255,255,255,0.4); top: 50%; left: 3%; animation-delay: 1.5s; }
        .shape:nth-child(6) { width: 40px; height: 40px; background: var(--c-yellow); top: 70%; right: 5%; animation-delay: 2.5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border: var(--border-thick);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 8px 8px 0px var(--c-dark);
            animation: bounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.8) translateY(50px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: var(--c-yellow);
            border: var(--border-thick);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 4px 4px 0px var(--c-dark);
            animation: wiggle 2s ease-in-out infinite;
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(-5deg); }
            50% { transform: rotate(5deg); }
        }

        .login-icon i {
            font-size: 2.5rem;
            color: var(--c-dark);
        }

        .login-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 2rem;
            color: var(--c-dark);
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: var(--c-dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: var(--border-thick);
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
            background: var(--bg-cream);
        }

        .form-input:focus {
            outline: none;
            box-shadow: 4px 4px 0px var(--c-teal);
            transform: translate(-2px, -2px);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            padding: 4px;
        }

        .password-toggle:hover {
            color: var(--c-blue);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #64748b;
            font-weight: 600;
        }

        .remember-label input {
            width: 18px;
            height: 18px;
            accent-color: var(--c-blue);
        }

        .forgot-link {
            color: var(--c-blue);
            font-weight: 700;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--c-coral);
            color: white;
            border: var(--border-thick);
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            text-transform: uppercase;
        }

        .btn-login:hover {
            transform: translate(-4px, -4px);
            box-shadow: var(--shadow-hard);
        }

        .btn-login:active {
            transform: translate(0, 0);
            box-shadow: none;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px dashed #e2e8f0;
            color: #64748b;
        }

        .login-footer a {
            color: var(--c-blue);
            font-weight: 700;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: var(--c-coral);
            font-size: 0.85rem;
            margin-top: 6px;
            font-weight: 600;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: white;
            font-weight: 700;
            text-decoration: none;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .emoji-decoration {
            font-size: 1.5rem;
            margin: 0 4px;
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="ri-user-star-fill"></i>
                </div>
                <h1 class="login-title">Welcome Back! <span class="emoji-decoration">⭐</span></h1>
                <p class="login-subtitle">Login to your student account</p>
            </div>

            @if (session('status'))
                <div style="background: #d1fae5; border: 2px solid #34d399; padding: 12px; border-radius: 10px; margin-bottom: 20px; color: #065f46; font-weight: 600; text-align: center;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="student_portal" value="1">

                <div class="form-group">
                    <label for="email" class="form-label"><i class="ri-mail-line" style="margin-right: 6px;"></i>Email Address</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your.email@example.com">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label"><i class="ri-lock-line" style="margin-right: 6px;"></i>Password</label>
                    <div class="password-wrapper">
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" style="padding-right: 45px;">
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="ri-eye-off-line" id="eyeIcon" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="options-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="ri-rocket-2-fill"></i> Let's Go!
                </button>

                <div class="login-footer">
                    <p>New student? <a href="{{ route('register') }}">Create an account</a></p>
                </div>
            </form>
        </div>

        <a href="/" class="back-link"><i class="ri-arrow-left-line"></i> Back to Homepage</a>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        }
    </script>
</body>
</html>
