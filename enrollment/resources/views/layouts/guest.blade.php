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
        /* Minimal critical keyframes (kept small) */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(6deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(20px) rotate(-6deg); }
        }
        @keyframes bounce { 0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);} }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-primary to-secondary relative overflow-hidden">
    <!-- Background shapes -->
    <div class="bg-shapes pointer-events-none absolute inset-0 -z-10">
        <span class="shape absolute left-6 top-10 text-4xl opacity-30" style="animation: float 15s ease-in-out infinite;">⭐</span>
        <span class="shape absolute left-16 bottom-16 text-3xl opacity-30" style="animation: float 15s ease-in-out 2s infinite;">🌈</span>
        <span class="shape absolute right-16 top-12 text-4xl opacity-30" style="animation: float 15s ease-in-out 4s infinite;">🎈</span>
        <span class="shape absolute right-8 bottom-20 text-5xl opacity-25" style="animation: float 15s ease-in-out 1s infinite;">✨</span>
        <span class="shape absolute left-1/2 bottom-6 text-3xl opacity-25" style="animation: float 15s ease-in-out 3s infinite;">🦋</span>
        <span class="shape absolute right-6 top-32 text-3xl opacity-30" style="animation: float 15s ease-in-out 5s infinite;">🌸</span>
    </div>
    
    <div class="z-10 w-full max-w-md">
        {{ $slot }}
        
        <a href="{{ url('/') }}" class="mt-6 inline-block text-white font-semibold">🏠 Back to Home</a>
    </div>
</body>
</html>
