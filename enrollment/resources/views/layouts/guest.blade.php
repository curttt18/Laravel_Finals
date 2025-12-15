<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars Daycare') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fredoka-one:400|nunito:400,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #74b9ff 0%, #a29bfe 50%, #fd79a8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated background shapes */
        .bg-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .shape {
            position: absolute;
            font-size: 4rem;
            opacity: 0.3;
            animation: float 15s ease-in-out infinite;
        }
        
        .shape:nth-child(1) { left: 5%; top: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { left: 15%; top: 70%; animation-delay: 2s; font-size: 3rem; }
        .shape:nth-child(3) { left: 75%; top: 15%; animation-delay: 4s; }
        .shape:nth-child(4) { left: 85%; top: 65%; animation-delay: 1s; font-size: 5rem; }
        .shape:nth-child(5) { left: 50%; top: 80%; animation-delay: 3s; }
        .shape:nth-child(6) { left: 90%; top: 30%; animation-delay: 5s; font-size: 3.5rem; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(10deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(30px) rotate(-10deg); }
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-mascot {
            font-size: 5rem;
            margin-bottom: 15px;
            animation: bounce 2s ease-in-out infinite;
            display: block;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        .login-title {
            font-family: 'Fredoka One', cursive;
            font-size: 2.2rem;
            background: linear-gradient(135deg, #6c5ce7, #fd79a8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .login-subtitle {
            color: #636e72;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }
        
        .form-label .emoji {
            margin-right: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 3px solid #dfe6e9;
            border-radius: 15px;
            font-size: 1rem;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #6c5ce7;
            background: white;
            box-shadow: 0 0 0 5px rgba(108, 92, 231, 0.1);
        }
        
        .form-input::placeholder {
            color: #b2bec3;
        }
        
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .remember-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #636e72;
            font-weight: 600;
            cursor: pointer;
        }
        
        .remember-label input {
            width: 20px;
            height: 20px;
            accent-color: #6c5ce7;
        }
        
        .forgot-link {
            color: #6c5ce7;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #fd79a8;
        }
        
        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: 'Fredoka One', cursive;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
        }
        
        .login-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(108, 92, 231, 0.5);
        }
        
        .login-btn:active {
            transform: translateY(-2px);
        }
        
        .register-link {
            text-align: center;
            margin-top: 30px;
            color: #636e72;
            font-weight: 600;
        }
        
        .register-link a {
            color: #fd79a8;
            text-decoration: none;
            font-weight: 700;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 8px;
            font-weight: 600;
        }
        
        .status-message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Background shapes -->
    <div class="bg-shapes">
        <span class="shape">⭐</span>
        <span class="shape">🌈</span>
        <span class="shape">🎈</span>
        <span class="shape">✨</span>
        <span class="shape">🦋</span>
        <span class="shape">🌸</span>
    </div>
    
    <div class="login-container">
        {{ $slot }}
        
        <a href="{{ url('/') }}" class="back-link">🏠 Back to Home</a>
    </div>
</body>
</html>
