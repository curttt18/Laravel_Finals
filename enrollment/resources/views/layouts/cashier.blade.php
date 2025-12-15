<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars') }} - Cashier</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --sidebar-bg: #1e1e2d;
            --sidebar-hover: #2a2a3c;
            --sidebar-active: #7c3aed;
            --text-light: #a2a3b7;
            --text-white: #ffffff;
            --bg-light: #f8f9fc;
            --card-bg: #ffffff;
            --border: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg-light); color: #1f2937; }
        .dashboard { display: flex; min-height: 100vh; }
        
        .sidebar { width: 260px; background: var(--sidebar-bg); padding: 24px 0; display: flex; flex-direction: column; position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-brand { padding: 0 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 24px; }
        .sidebar-brand h1 { color: var(--text-white); font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { background: var(--primary); padding: 8px 10px; border-radius: 8px; font-size: 0.875rem; }
        
        .nav-section { padding: 0 16px; margin-bottom: 8px; }
        .nav-section-title { color: var(--text-light); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 12px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-light); text-decoration: none; border-radius: 8px; margin: 2px 0; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; }
        .nav-item:hover { background: var(--sidebar-hover); color: var(--text-white); }
        .nav-item.active { background: var(--sidebar-active); color: var(--text-white); }
        .nav-item svg { width: 20px; height: 20px; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }
        
        .user-section { margin-top: auto; padding: 16px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; margin-bottom: 8px; }
        .user-avatar { width: 40px; height: 40px; background: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem; }
        .user-details h4 { color: var(--text-white); font-size: 0.875rem; font-weight: 600; }
        .user-details p { color: var(--text-light); font-size: 0.75rem; }
        .logout-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.1); color: var(--text-light); border-radius: 8px; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .logout-btn:hover { background: var(--danger); border-color: var(--danger); color: white; }
        
        .main { flex: 1; margin-left: 260px; padding: 24px 32px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: #111827; }
        .breadcrumb { color: #6b7280; font-size: 0.875rem; }
        
        .card { background: var(--card-bg); border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid var(--border); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .card-title { font-size: 1rem; font-weight: 600; color: #111827; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px; }
        .stat-card { background: var(--card-bg); border-radius: 12px; padding: 20px; border: 1px solid var(--border); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stat-card .label { color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 8px; }
        .stat-card .value { font-size: 1.75rem; font-weight: 700; color: #111827; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px 16px; background: #f9fafb; color: #6b7280; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.875rem; color: #374151; }
        tr:hover td { background: #f9fafb; }
        
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 16px; border-radius: 8px; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary { background: #f3f4f6; color: #374151; }
        .btn-success { background: var(--success); color: white; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.875rem; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1); }
        
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.875rem; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        
        @media (max-width: 1024px) { .sidebar { width: 80px; } .nav-section-title, .nav-item span, .user-details, .logout-btn span { display: none; } .nav-item { justify-content: center; } .main { margin-left: 80px; } }
        @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; padding: 16px; } }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h1><span>LS</span><span>Cashier Portal</span></h1>
            </div>
            
            <nav class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('cashier.dashboard') }}" class="nav-item {{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>
            </nav>
            
            <nav class="nav-section">
                <div class="nav-section-title">Management</div>
                <a href="{{ route('cashier.students.index') }}" class="nav-item {{ request()->routeIs('cashier.students.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Students</span>
                </a>
                <a href="{{ route('cashier.payments.index') }}" class="nav-item {{ request()->routeIs('cashier.payments.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Payments</span>
                </a>
            </nav>
            
            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                    <div class="user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <p>Cashier</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <main class="main">
            <div class="page-header">
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="breadcrumb">@yield('breadcrumb', 'Cashier / Dashboard')</p>
                </div>
                @yield('page-actions')
            </div>
            
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
            
            @yield('content')
        </main>
    </div>
</body>
</html>
