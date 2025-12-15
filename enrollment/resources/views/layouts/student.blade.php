<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars') }} - Student Portal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --bg-light: #f8f9fc;
            --card-bg: #ffffff;
            --border: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
        }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg-light); color: #1f2937; min-height: 100vh; }
        
        .navbar {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand span {
            background: var(--primary);
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .navbar-user .name {
            font-weight: 500;
            color: #374151;
        }
        
        .logout-btn {
            padding: 8px 16px;
            background: #f3f4f6;
            color: #374151;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .logout-btn:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        
        .main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }
        
        .welcome-header {
            margin-bottom: 32px;
        }
        
        .welcome-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }
        
        .welcome-header p {
            color: #6b7280;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }
        
        .card-header svg {
            width: 24px;
            height: 24px;
            color: var(--primary);
        }
        
        .card-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .info-row:last-child { border-bottom: none; }
        
        .info-label { color: #6b7280; font-size: 0.875rem; }
        .info-value { color: #111827; font-weight: 500; font-size: 0.875rem; }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        
        .amount { color: var(--success); font-weight: 600; }
        
        .grade-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-top: 12px;
        }
        
        .grade-item {
            text-align: center;
            padding: 12px 8px;
            background: #f9fafb;
            border-radius: 8px;
        }
        
        .grade-item .label {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .grade-item .value {
            font-weight: 600;
            color: var(--primary);
            text-transform: capitalize;
            font-size: 0.8rem;
        }
        
        .empty-state {
            text-align: center;
            color: #9ca3af;
            padding: 24px;
        }
        
        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; }
            .main { padding: 16px; }
            .cards-grid { grid-template-columns: 1fr; }
            .grade-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <span>LS</span>
            Little Stars - Student Portal
        </div>
        <div class="navbar-user">
            <span class="name">Welcome, {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>
    
    <main class="main">
        @yield('content')
    </main>
</body>
</html>
