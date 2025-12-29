<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars') }} - Cashier</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --c-coral: #F96E5B;
            --c-blue: #3F9AAE;
            --c-teal: #79C9C5;
            --c-yellow: #FFE2AF;
            --c-dark: #2D3748;
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --sidebar-bg: #3b2a5c;
            --sidebar-hover: #4c3872;
            --sidebar-active: #8b5cf6;
            --bg-cream: #FFFCF5;
            --bg-white: #FFFFFF;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-cream); color: var(--c-dark); }
        h1, h2, h3, h4 { font-family: 'Fredoka', sans-serif; }
        .dashboard { display: flex; min-height: 100vh; }
        
        .sidebar { width: 270px; background: var(--sidebar-bg); padding: 0; display: flex; flex-direction: column; position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-brand { padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand a { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-icon { width: 44px; height: 44px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.4rem; }
        .brand-text { color: white; font-family: 'Fredoka', sans-serif; font-size: 1.15rem; font-weight: 600; }
        .brand-text span { display: block; font-size: 0.7rem; color: #c4b5fd; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
        
        .nav-section { padding: 20px 16px 8px; }
        .nav-section-title { color: rgba(255,255,255,0.4); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 0 12px 8px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 10px; margin: 2px 0; font-size: 0.9rem; font-weight: 500; transition: all 0.2s; }
        .nav-item i { font-size: 1.2rem; width: 24px; text-align: center; }
        .nav-item:hover { background: var(--sidebar-hover); color: white; }
        .nav-item.active { background: var(--sidebar-active); color: white; }
        
        .user-section { margin-top: auto; padding: 16px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 10px; margin-bottom: 12px; }
        .user-avatar { width: 42px; height: 42px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem; }
        .user-details h4 { color: white; font-size: 0.9rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; }
        .user-details p { color: rgba(255,255,255,0.5); font-size: 0.75rem; }
        .logout-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.7); border-radius: 8px; font-size: 0.85rem; font-weight: 500; cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .logout-btn:hover { background: var(--danger); border-color: var(--danger); color: white; }
        
        .main { flex: 1; margin-left: 270px; padding: 28px 36px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .page-title { font-size: 1.6rem; font-weight: 700; color: var(--c-dark); }
        .breadcrumb { color: #64748b; font-size: 0.85rem; margin-top: 4px; }
        
        .card { background: var(--bg-white); border-radius: 16px; padding: 24px; margin-bottom: 24px; border: 2px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .card-title { font-size: 1.1rem; font-weight: 600; color: var(--c-dark); }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .stat-card { background: var(--bg-white); border-radius: 16px; padding: 22px; border: 2px solid var(--border); position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--primary); }
        .stat-card .label { color: #64748b; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; }
        .stat-card .value { font-size: 1.8rem; font-weight: 700; color: var(--c-dark); font-family: 'Fredoka', sans-serif; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 14px 16px; background: var(--bg-cream); color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid var(--border); }
        th:first-child { border-radius: 10px 0 0 0; }
        th:last-child { border-radius: 0 10px 0 0; }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.9rem; color: var(--c-dark); }
        tr:hover td { background: #fafafa; }
        
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 10px; font-size: 0.875rem; font-weight: 600; text-decoration: none; border: 2px solid transparent; cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-primary { background: var(--primary); color: white; border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-secondary { background: var(--bg-cream); color: var(--c-dark); border-color: var(--border); }
        .btn-success { background: var(--success); color: white; border-color: var(--success); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-sm { padding: 8px 14px; font-size: 0.8rem; }
        
        .badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--c-dark); margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 16px; border: 2px solid var(--border); border-radius: 10px; font-size: 0.9rem; font-family: inherit; transition: all 0.2s; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15); }
        
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        
        
        /* Clickable Stat Card */
        .stat-card .change { font-size: 0.75rem; font-weight: 600; margin-top: 6px; }
        .stat-card .change.positive { color: var(--success); }
        .stat-card .change.negative { color: var(--danger); }
        .stat-card-clickable { cursor: pointer; transition: all 0.2s ease; }
        .stat-card-clickable:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); border-color: var(--primary); }
        
        /* Sortable table headers */
        th.sortable { cursor: pointer; user-select: none; position: relative; padding-right: 24px; transition: background 0.2s; }
        th.sortable:hover { background: #e2e8f0; }
        th.sortable::after { content: '↕'; position: absolute; right: 8px; opacity: 0.4; font-size: 0.7rem; }
        th.sortable.asc::after { content: '↑'; opacity: 1; color: var(--primary); }
        th.sortable.desc::after { content: '↓'; opacity: 1; color: var(--primary); }
        
        @media (max-width: 1024px) { .sidebar { width: 80px; } .brand-text, .nav-section-title, .nav-item span, .user-details, .logout-btn span { display: none; } .nav-item { justify-content: center; } .main { margin-left: 80px; } }
        @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; padding: 16px; } }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('cashier.dashboard') }}">
                    <div class="brand-icon"><i class="ri-shining-2-fill"></i></div>
                    <div class="brand-text">Little Stars<span>Cashier Portal</span></div>
                </a>
            </div>
            
            <nav class="nav-section">
                <div class="nav-section-title">Main</div>
                <a href="{{ route('cashier.dashboard') }}" class="nav-item {{ request()->routeIs('cashier.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-3-line"></i><span>Dashboard</span>
                </a>
            </nav>
            
            <nav class="nav-section">
                <div class="nav-section-title">Management</div>
                <a href="{{ route('cashier.students.index') }}" class="nav-item {{ request()->routeIs('cashier.students.*') ? 'active' : '' }}">
                    <i class="ri-user-heart-line"></i><span>Students</span>
                </a>
                <a href="{{ route('cashier.payments.index') }}" class="nav-item {{ request()->routeIs('cashier.payments.*') ? 'active' : '' }}">
                    <i class="ri-bank-card-line"></i><span>Payments</span>
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
                    <button type="submit" class="logout-btn"><i class="ri-logout-box-r-line"></i><span>Logout</span></button>
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
            
            @if(session('success'))<div class="alert alert-success"><i class="ri-checkbox-circle-fill"></i>{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-error"><i class="ri-error-warning-fill"></i>{{ session('error') }}</div>@endif
            
            @yield('content')
        </main>
    </div>
    
    <script>
    // Sortable Table Functionality
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('th.sortable').forEach(function(header) {
            header.addEventListener('click', function() {
                const table = this.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const columnIndex = Array.from(this.parentElement.children).indexOf(this);
                const sortType = this.dataset.sortType || 'text';
                const isAsc = this.classList.contains('asc');
                table.querySelectorAll('th.sortable').forEach(th => th.classList.remove('asc', 'desc'));
                this.classList.add(isAsc ? 'desc' : 'asc');
                rows.sort(function(a, b) {
                    const aCell = a.cells[columnIndex], bCell = b.cells[columnIndex];
                    if (!aCell || !bCell) return 0;
                    let aVal = aCell.textContent.trim(), bVal = bCell.textContent.trim();
                    if (sortType === 'number') { aVal = parseFloat(aVal.replace(/[₱,#]/g, '')) || 0; bVal = parseFloat(bVal.replace(/[₱,#]/g, '')) || 0; return isAsc ? bVal - aVal : aVal - bVal; }
                    if (sortType === 'date') { aVal = new Date(aVal); bVal = new Date(bVal); return isAsc ? bVal - aVal : aVal - bVal; }
                    return isAsc ? bVal.localeCompare(aVal) : aVal.localeCompare(bVal);
                });
                rows.forEach(function(row) { tbody.appendChild(row); });
            });
        });
    });
    </script>
</body>
</html>
