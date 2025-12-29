<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Little Stars') }} - Student Portal</title>
    
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
            --bg-cream: #FFFCF5;
            --bg-white: #FFFFFF;
            --border: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg-cream); 
            color: var(--c-dark); 
            min-height: 100vh; 
        }
        
        h1, h2, h3, h4 { font-family: 'Fredoka', sans-serif; }
        
        .navbar {
            background: var(--bg-white);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--c-coral);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
        }
        
        .brand-text {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--c-dark);
        }
        
        .brand-text span {
            display: block;
            font-size: 0.7rem;
            color: var(--c-blue);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-greeting {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--c-teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--c-dark);
        }
        
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--bg-cream);
            color: var(--c-dark);
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .logout-btn:hover {
            background: #ef4444;
            color: white;
            border-color: #ef4444;
        }
        
        .main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 40px;
        }
        
        .welcome-header {
            margin-bottom: 28px;
        }
        
        .welcome-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--c-dark);
            margin-bottom: 8px;
        }
        
        .welcome-header p {
            color: #64748b;
            font-size: 0.95rem;
        }
        
        /* Quick Stats Row */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }
        
        .stat-item {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 20px 24px;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.2s;
        }
        
        .stat-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
        
        .stat-item i {
            font-size: 2rem;
            color: var(--c-coral);
        }
        
        .stat-content {
            display: flex;
            flex-direction: column;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--c-dark);
            font-family: 'Fredoka', sans-serif;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
        }
        
        /* Main 2-column grid */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        /* Full width section */
        .full-width-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        
        .card {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 24px;
            border: 2px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }
        
        .card-header i {
            font-size: 1.5rem;
            color: var(--c-coral);
        }
        
        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--c-dark);
            flex: 1;
        }
        
        .card-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            background: var(--bg-cream);
            border-radius: 20px;
            color: #64748b;
            font-weight: 600;
        }
        
        /* Info grid for student details */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .info-item {
            padding: 14px;
            background: var(--bg-cream);
            border-radius: 10px;
            border: 1px solid var(--border);
        }
        
        .info-item.full-width {
            grid-column: span 2;
        }
        
        .info-label { 
            display: block;
            color: #64748b; 
            font-size: 0.75rem; 
            font-weight: 600; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value { 
            color: var(--c-dark); 
            font-weight: 600; 
            font-size: 0.95rem; 
        }
        
        /* Enrollment items */
        .enrollment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            background: var(--bg-cream);
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid var(--border);
        }
        
        .enrollment-item:last-child {
            margin-bottom: 0;
        }
        
        .enrollment-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .school-year {
            font-weight: 700;
            color: var(--c-dark);
        }
        
        .enrollment-date {
            font-size: 0.8rem;
            color: #64748b;
        }
        
        /* Payment table styles */
        .payments-table {
            display: flex;
            flex-direction: column;
        }
        
        .table-header, .table-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 12px;
            padding: 14px 16px;
            align-items: center;
        }
        
        .table-header {
            background: var(--bg-cream);
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .table-row {
            border-bottom: 1px solid #f1f5f9;
        }
        
        .table-row:last-child {
            border-bottom: none;
        }
        
        .fee-name {
            font-weight: 600;
            color: var(--c-dark);
        }
        
        .fee-date {
            color: #64748b;
            font-size: 0.9rem;
        }
        
        .amount {
            font-weight: 700;
            color: var(--success);
            text-align: right;
        }
        
        /* Grade card styles */
        .grade-card {
            background: var(--bg-cream);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }
        
        .grade-card:last-child {
            margin-bottom: 0;
        }
        
        .grade-header {
            margin-bottom: 16px;
        }
        
        .grade-period {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .teacher-name {
            font-size: 0.85rem;
            color: #64748b;
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }
        
        .skill-item {
            text-align: center;
            padding: 12px 8px;
            background: var(--bg-white);
            border-radius: 10px;
            border: 2px solid var(--border);
        }
        
        .skill-item.excellent, .skill-item.outstanding { border-color: #10b981; background: #ecfdf5; }
        .skill-item.good, .skill-item.satisfactory { border-color: #3b82f6; background: #eff6ff; }
        .skill-item.needs_improvement { border-color: #f59e0b; background: #fffbeb; }
        
        .skill-label {
            display: block;
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .skill-value {
            font-weight: 700;
            color: var(--c-dark);
            font-size: 0.75rem;
        }
        
        .remarks {
            margin-top: 14px;
            padding: 12px;
            background: var(--bg-white);
            border-radius: 8px;
            font-size: 0.85rem;
            color: #64748b;
            border: 1px solid var(--border);
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        
        .empty-state {
            text-align: center;
            color: #94a3b8;
            padding: 32px;
        }
        
        .empty-state i {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 12px;
            opacity: 0.5;
        }
        
        @media (max-width: 1024px) {
            .quick-stats { grid-template-columns: repeat(2, 1fr); }
            .main-grid { grid-template-columns: 1fr; }
            .full-width-section { grid-template-columns: 1fr; }
            .skills-grid { grid-template-columns: repeat(3, 1fr); }
        }
        
        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; }
            .main { padding: 16px; }
            .quick-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .stat-item { padding: 16px; }
            .stat-value { font-size: 1.2rem; }
            .info-grid { grid-template-columns: 1fr; }
            .info-item.full-width { grid-column: span 1; }
            .table-header, .table-row { grid-template-columns: 1fr 1fr; }
            .table-header span:nth-child(2), .table-row .fee-date { display: none; }
            .skills-grid { grid-template-columns: repeat(2, 1fr); }
            .user-name { display: none; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-brand">
            <div class="brand-icon"><i class="ri-shining-2-fill"></i></div>
            <div class="brand-text">Little Stars<span>Student Portal</span></div>
        </a>
        <div class="navbar-user">
            <div class="user-greeting">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn"><i class="ri-logout-box-r-line"></i> Logout</button>
            </form>
        </div>
    </nav>
    
    <main class="main">
        @yield('content')
    </main>
</body>
</html>
