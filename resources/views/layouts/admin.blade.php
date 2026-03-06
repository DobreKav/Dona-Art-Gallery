<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ') - Dona Art Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --admin-bg: #F4F6F9;
            --admin-sidebar: #1A1D2E;
            --admin-sidebar-hover: #252840;
            --admin-white: #FFFFFF;
            --admin-text: #2C3E50;
            --admin-text-light: #7F8C9B;
            --admin-primary: #8B6914;
            --admin-primary-light: #C9A84C;
            --admin-success: #27AE60;
            --admin-warning: #F39C12;
            --admin-danger: #E74C3C;
            --admin-info: #3498DB;
            --admin-border: #E5E9F0;
            --admin-radius: 10px;
            --admin-shadow: 0 2px 10px rgba(0,0,0,0.06);
            --admin-transition: all 0.2s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--admin-sidebar);
            color: white;
            z-index: 100;
            transition: var(--admin-transition);
            overflow-y: auto;
        }

        .admin-sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .admin-sidebar-brand h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .admin-sidebar-brand span {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.3);
            padding: 1rem 1.5rem 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--admin-transition);
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            color: white;
            background: var(--admin-sidebar-hover);
        }

        .sidebar-link.active {
            color: white;
            background: var(--admin-sidebar-hover);
            border-left-color: var(--admin-primary-light);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        .sidebar-link .badge {
            margin-left: auto;
            background: var(--admin-danger);
            color: white;
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 10px;
        }

        /* Main content */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            transition: var(--admin-transition);
        }

        /* Top bar */
        .admin-topbar {
            background: var(--admin-white);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--admin-border);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-topbar h1 {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--admin-text);
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-link {
            color: var(--admin-text-light);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .topbar-link:hover {
            color: var(--admin-primary);
        }

        /* Content area */
        .admin-content {
            padding: 2rem;
        }

        /* Cards */
        .admin-card {
            background: var(--admin-white);
            border-radius: var(--admin-radius);
            border: 1px solid var(--admin-border);
            box-shadow: var(--admin-shadow);
        }

        .admin-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-card-header h3 {
            font-size: 1rem;
            font-weight: 600;
        }

        .admin-card-body {
            padding: 1.5rem;
        }

        /* Stats grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--admin-white);
            border-radius: var(--admin-radius);
            padding: 1.5rem;
            border: 1px solid var(--admin-border);
            box-shadow: var(--admin-shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-icon.primary { background: rgba(139,105,20,0.1); color: var(--admin-primary); }
        .stat-icon.success { background: rgba(39,174,96,0.1); color: var(--admin-success); }
        .stat-icon.warning { background: rgba(243,156,18,0.1); color: var(--admin-warning); }
        .stat-icon.info { background: rgba(52,152,219,0.1); color: var(--admin-info); }

        .stat-info h4 {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-info span {
            font-size: 0.8rem;
            color: var(--admin-text-light);
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--admin-text-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--admin-border);
            background: var(--admin-bg);
        }

        .admin-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--admin-border);
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .admin-table tr:hover td {
            background: rgba(0,0,0,0.01);
        }

        .admin-table .thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* Buttons */
        .btn-admin {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--admin-transition);
        }

        .btn-admin-primary {
            background: var(--admin-primary);
            color: white;
        }

        .btn-admin-primary:hover {
            background: #6B5010;
        }

        .btn-admin-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.78rem;
        }

        .btn-admin-success { background: rgba(39,174,96,0.1); color: var(--admin-success); }
        .btn-admin-warning { background: rgba(243,156,18,0.1); color: var(--admin-warning); }
        .btn-admin-danger { background: rgba(231,76,60,0.1); color: var(--admin-danger); }
        .btn-admin-info { background: rgba(52,152,219,0.1); color: var(--admin-info); }

        .btn-admin-success:hover { background: var(--admin-success); color: white; }
        .btn-admin-warning:hover { background: var(--admin-warning); color: white; }
        .btn-admin-danger:hover { background: var(--admin-danger); color: white; }
        .btn-admin-info:hover { background: var(--admin-info); color: white; }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending { background: rgba(243,156,18,0.1); color: #D4920A; }
        .status-confirmed { background: rgba(52,152,219,0.1); color: #2980B9; }
        .status-shipped { background: rgba(155,89,182,0.1); color: #8E44AD; }
        .status-delivered { background: rgba(39,174,96,0.1); color: #27AE60; }
        .status-cancelled { background: rgba(231,76,60,0.1); color: #C0392B; }

        /* Form */
        .form-group-admin {
            margin-bottom: 1.25rem;
        }

        .form-label-admin {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--admin-text);
            margin-bottom: 0.4rem;
        }

        .form-input-admin {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1.5px solid var(--admin-border);
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: var(--admin-transition);
            outline: none;
        }

        .form-input-admin:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(139,105,20,0.1);
        }

        textarea.form-input-admin {
            min-height: 100px;
            resize: vertical;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .form-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--admin-primary);
        }

        .form-row-admin {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-error-admin {
            color: var(--admin-danger);
            font-size: 0.78rem;
            margin-top: 0.3rem;
        }

        /* Alerts */
        .admin-alert {
            padding: 0.85rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.88rem;
        }

        .admin-alert-success {
            background: rgba(39,174,96,0.1);
            color: var(--admin-success);
            border: 1px solid rgba(39,174,96,0.2);
        }

        /* Image preview */
        .image-preview {
            width: 200px;
            height: 200px;
            border-radius: var(--admin-radius);
            border: 2px dashed var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview .placeholder {
            color: var(--admin-text-light);
            text-align: center;
        }

        .image-preview .placeholder i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Pagination */
        .admin-pagination {
            display: flex;
            justify-content: center;
            gap: 0.3rem;
            margin-top: 1.5rem;
        }

        .admin-pagination a, .admin-pagination span {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.82rem;
            text-decoration: none;
            color: var(--admin-text);
            border: 1px solid var(--admin-border);
        }

        .admin-pagination .active span {
            background: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .admin-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-row-admin {
                grid-template-columns: 1fr;
            }

            .admin-table {
                font-size: 0.8rem;
            }

            .admin-table .hide-mobile {
                display: none;
            }
        }
    </style>
    @yield('admin_styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-brand">
            <h2>🎨 Dona Art</h2>
            <span>Админ Панел</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-label">Главно</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Контролна Табла
            </a>

            <div class="sidebar-label">Продавница</div>
            <a href="{{ route('admin.paintings.index') }}" class="sidebar-link {{ request()->routeIs('admin.paintings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-palette"></i> Слики
            </a>
            <a href="{{ route('admin.paintings.create') }}" class="sidebar-link {{ request()->routeIs('admin.paintings.create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus"></i> Додади Слика
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i> Нарачки
                @php $pendCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                @if($pendCount > 0)
                    <span class="badge">{{ $pendCount }}</span>
                @endif
            </a>

            <div class="sidebar-label">Систем</div>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <i class="fa-solid fa-external-link-alt"></i> Погледни Страница
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;font-family:inherit">
                    <i class="fa-solid fa-sign-out-alt"></i> Одјава
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="admin-main">
        <div class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="sidebar-toggle" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>@yield('page_title', 'Контролна Табла')</h1>
            </div>
            <div class="admin-topbar-right">
                <a href="{{ route('home') }}" class="topbar-link" target="_blank"><i class="fa-solid fa-external-link-alt"></i> Страница</a>
            </div>
        </div>

        <div class="admin-content">
            @if(session('success'))
                <div class="admin-alert admin-alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @yield('admin_content')
        </div>
    </div>

    <script>
        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('adminSidebar');
            if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
    @yield('admin_scripts')
</body>
</html>
