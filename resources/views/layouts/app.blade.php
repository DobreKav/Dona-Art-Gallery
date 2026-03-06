<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Дона Арт Галерија') - Македонка Димова</title>
    <meta name="description" content="@yield('meta_description', 'Уметничка галерија на Македонка Димова - оригинални уметнички слики')">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
        :root {
            --color-bg: #FAF8F5;
            --color-bg-warm: #F5F0EB;
            --color-bg-card: #FFFFFF;
            --color-text: #2C2C2C;
            --color-text-light: #6B6B6B;
            --color-text-muted: #9A9A9A;
            --color-primary: #8B6914;
            --color-primary-light: #C9A84C;
            --color-primary-dark: #6B5010;
            --color-accent: #B8860B;
            --color-border: #E8E4DF;
            --color-border-light: #F0ECE7;
            --color-success: #4A7C59;
            --color-danger: #C44536;
            --color-white: #FFFFFF;
            --color-black: #1A1A1A;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --font-display: 'Playfair Display', serif;
            --font-body: 'Inter', sans-serif;
            --font-elegant: 'Cormorant Garamond', serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-bg);
            color: var(--color-text);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== NAVIGATION ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(250, 248, 245, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border-light);
            transition: var(--transition);
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-sm);
        }

        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }

        .navbar-brand {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .navbar-brand .brand-name {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--color-black);
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .navbar-brand .brand-subtitle {
            font-family: var(--font-elegant);
            font-size: 0.85rem;
            color: var(--color-text-light);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-weight: 300;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--color-text);
            font-size: 0.9rem;
            font-weight: 400;
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            letter-spacing: 0.02em;
            position: relative;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--color-primary);
            background: rgba(139, 105, 20, 0.06);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: var(--color-primary);
            border-radius: 1px;
        }

        /* Shopping bag */
        .cart-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cart-badge {
            position: absolute;
            top: -2px;
            right: -4px;
            background: var(--color-primary);
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .cart-icon {
            font-size: 1.15rem;
        }

        /* Mobile menu */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--color-text);
            cursor: pointer;
            padding: 0.5rem;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .mobile-overlay.active {
            opacity: 1;
        }

        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100vh;
            background: var(--color-white);
            z-index: 1001;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
        }

        .mobile-nav.active {
            right: 0;
        }

        .mobile-nav-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: var(--color-text-light);
        }

        .mobile-nav-links {
            list-style: none;
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-links a {
            display: block;
            padding: 1rem;
            text-decoration: none;
            color: var(--color-text);
            font-size: 1.05rem;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .mobile-nav-links a:hover,
        .mobile-nav-links a.active {
            background: rgba(139, 105, 20, 0.06);
            color: var(--color-primary);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding-top: 80px;
            min-height: 100vh;
        }

        /* ===== SECTIONS ===== */
        .section {
            padding: 5rem 2rem;
        }

        .section-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-label {
            font-family: var(--font-elegant);
            font-size: 0.95rem;
            color: var(--color-primary);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-weight: 400;
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--color-black);
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            font-size: 1.05rem;
            color: var(--color-text-light);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--color-primary-light), var(--color-primary));
            margin: 1rem auto;
            border-radius: 1px;
        }

        /* ===== PAINTING GRID ===== */
        .paintings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .painting-card {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--color-border-light);
            position: relative;
            group: true;
        }

        .painting-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: var(--color-border);
        }

        .painting-card-image {
            position: relative;
            padding-top: 110%;
            overflow: hidden;
        }

        .painting-card-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .painting-card:hover .painting-card-image img {
            transform: scale(1.05);
        }

        .painting-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 1.5rem;
        }

        .painting-card:hover .painting-card-overlay {
            opacity: 1;
        }

        .painting-card-actions {
            display: flex;
            gap: 0.75rem;
        }

        .painting-card-actions .btn-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: var(--color-white);
            color: var(--color-text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .painting-card-actions .btn-icon:hover {
            background: var(--color-primary);
            color: white;
            transform: scale(1.1);
        }

        .painting-card-info {
            padding: 1.25rem 1.5rem;
        }

        .painting-card-info h3 {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .painting-card-info h3 a {
            text-decoration: none;
            color: var(--color-text);
            transition: color 0.2s;
        }

        .painting-card-info h3 a:hover {
            color: var(--color-primary);
        }

        .painting-card-meta {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            margin-bottom: 0.75rem;
        }

        .painting-card-price {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary-dark);
        }

        .painting-card-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--color-primary);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            z-index: 2;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 2rem;
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            letter-spacing: 0.02em;
        }

        .btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(139, 105, 20, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--color-text);
            border: 1.5px solid var(--color-border);
        }

        .btn-secondary:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: rgba(139, 105, 20, 0.04);
        }

        .btn-outline-gold {
            background: transparent;
            color: var(--color-primary);
            border: 1.5px solid var(--color-primary);
        }

        .btn-outline-gold:hover {
            background: var(--color-primary);
            color: white;
        }

        .btn-lg {
            padding: 1rem 2.5rem;
            font-size: 1rem;
        }

        .btn-sm {
            padding: 0.5rem 1.2rem;
            font-size: 0.8rem;
        }

        .btn-full {
            width: 100%;
            justify-content: center;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--color-black);
            color: rgba(255,255,255,0.7);
            padding: 4rem 2rem 2rem;
        }

        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-brand .brand-name {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.5rem;
        }

        .footer-brand p {
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-social a:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
        }

        .footer h4 {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 500;
            color: white;
            margin-bottom: 1.2rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.6rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--color-primary-light);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
        }

        /* ===== TOAST NOTIFICATION ===== */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--color-black);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 350px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast i {
            color: var(--color-primary-light);
            font-size: 1.1rem;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: rgba(74, 124, 89, 0.1);
            color: var(--color-success);
            border: 1px solid rgba(74, 124, 89, 0.2);
        }

        .alert-error {
            background: rgba(196, 69, 54, 0.1);
            color: var(--color-danger);
            border: 1px solid rgba(196, 69, 54, 0.2);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar-inner {
                padding: 0 1rem;
                height: 65px;
            }

            .navbar-brand .brand-name {
                font-size: 1.3rem;
            }

            .nav-links {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .mobile-nav, .mobile-overlay {
                display: block;
            }

            .main-content {
                padding-top: 65px;
            }

            .section {
                padding: 3rem 1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .paintings-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .painting-card-info {
                padding: 0.75rem 1rem;
            }

            .painting-card-info h3 {
                font-size: 0.95rem;
            }

            .painting-card-price {
                font-size: 1rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .btn-lg {
                padding: 0.85rem 2rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .paintings-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== FORM STYLES ===== */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--color-text);
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
            font-size: 0.9rem;
            color: var(--color-text);
            background: var(--color-white);
            transition: var(--transition);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(139, 105, 20, 0.1);
        }

        .form-input::placeholder {
            color: var(--color-text-muted);
        }

        textarea.form-input {
            min-height: 100px;
            resize: vertical;
        }

        .form-error {
            color: var(--color-danger);
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        /* ===== LOADING SPINNER ===== */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s ease infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== UTILITIES ===== */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mt-4 { margin-top: 2rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 2rem; }

        /* Page transition */
        .page-enter {
            animation: pageEnter 0.6s ease;
        }

        @keyframes pageEnter {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="navbar-brand">
                <span class="brand-name">Dona Art Gallery</span>
                <span class="brand-subtitle">Македонка Димова</span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Дома</a></li>
                <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Продавница</a></li>
                <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Галерија</a></li>
                <li><a href="{{ route('bio') }}" class="{{ request()->routeIs('bio') ? 'active' : '' }}">За Мене</a></li>
                <li>
                    <a href="{{ route('cart.index') }}" class="cart-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bag-shopping cart-icon"></i>
                        <span class="cart-badge" id="cart-count" style="{{ $cartCount ?? 0 > 0 ? '' : 'display:none' }}">{{ $cartCount ?? 0 }}</span>
                    </a>
                </li>
            </ul>

            <button class="mobile-toggle" id="mobileToggle" aria-label="Мени">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile nav -->
    <div class="mobile-nav" id="mobileNav">
        <button class="mobile-nav-close" id="mobileClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <ul class="mobile-nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house" style="width:20px;text-align:center;margin-right:0.5rem"></i> Дома
            </a></li>
            <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">
                <i class="fa-solid fa-palette" style="width:20px;text-align:center;margin-right:0.5rem"></i> Продавница
            </a></li>
            <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">
                <i class="fa-solid fa-images" style="width:20px;text-align:center;margin-right:0.5rem"></i> Галерија
            </a></li>
            <li><a href="{{ route('bio') }}" class="{{ request()->routeIs('bio') ? 'active' : '' }}">
                <i class="fa-solid fa-user" style="width:20px;text-align:center;margin-right:0.5rem"></i> За Мене
            </a></li>
            <li><a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bag-shopping" style="width:20px;text-align:center;margin-right:0.5rem"></i> Кошничка
                <span class="cart-badge" id="cart-count-mobile" style="{{ $cartCount ?? 0 > 0 ? '' : 'display:none' }}; position:static; margin-left:0.5rem">{{ $cartCount ?? 0 }}</span>
            </a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content page-enter">
        @if(session('success'))
            <div style="max-width:1400px;margin:1rem auto;padding:0 2rem">
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div style="max-width:1400px;margin:1rem auto;padding:0 2rem">
                <div class="alert alert-error">
                    <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="brand-name">Dona Art Gallery</div>
                    <p>Уметничка галерија на Македонка Димова. Секоја слика раскажува приказна, секоја боја носи емоција.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="Pinterest"><i class="fa-brands fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Навигација</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Дома</a></li>
                        <li><a href="{{ route('shop.index') }}">Продавница</a></li>
                        <li><a href="{{ route('gallery') }}">Галерија</a></li>
                        <li><a href="{{ route('bio') }}">За Мене</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Помош</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('cart.index') }}">Кошничка</a></li>
                        <li><a href="#">Достава</a></li>
                        <li><a href="#">Контакт</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Контакт</h4>
                    <ul class="footer-links">
                        <li><i class="fa-solid fa-location-dot" style="width:16px;margin-right:0.3rem"></i> Македонија</li>
                        <li><i class="fa-solid fa-envelope" style="width:16px;margin-right:0.3rem"></i> info@donaart.mk</li>
                        <li><i class="fa-solid fa-phone" style="width:16px;margin-right:0.3rem"></i> +389 XX XXX XXX</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Dona Art Gallery - Македонка Димова. Сите права задржани.
            </div>
        </div>
    </footer>

    <!-- Toast notification -->
    <div class="toast" id="toast">
        <i class="fa-solid fa-check-circle"></i>
        <span id="toastMessage"></span>
    </div>

    <!-- AOS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 700,
            once: true,
            offset: 50,
        });

        // Navbar scroll
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile menu
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileNav = document.getElementById('mobileNav');
        const mobileClose = document.getElementById('mobileClose');

        function openMobileNav() {
            mobileOverlay.style.display = 'block';
            mobileNav.style.display = 'block';
            setTimeout(() => {
                mobileOverlay.classList.add('active');
                mobileNav.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeMobileNav() {
            mobileOverlay.classList.remove('active');
            mobileNav.classList.remove('active');
            setTimeout(() => {
                mobileOverlay.style.display = 'none';
                mobileNav.style.display = 'none';
            }, 300);
            document.body.style.overflow = '';
        }

        mobileToggle.addEventListener('click', openMobileNav);
        mobileClose.addEventListener('click', closeMobileNav);
        mobileOverlay.addEventListener('click', closeMobileNav);

        // Add to cart AJAX
        function addToCart(paintingId, button) {
            const originalContent = button.innerHTML;
            button.innerHTML = '<div class="spinner"></div>';
            button.disabled = true;

            fetch(`{{ url('/cart/add') }}/${paintingId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateCartBadge(data.cartCount);
                    showToast(data.message);
                }
                button.innerHTML = originalContent;
                button.disabled = false;
            })
            .catch(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        }

        function updateCartBadge(count) {
            const badges = document.querySelectorAll('#cart-count, #cart-count-mobile');
            badges.forEach(badge => {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            document.getElementById('toastMessage').textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // Load cart count on page load
        fetch('{{ route("cart.count") }}')
            .then(r => r.json())
            .then(d => updateCartBadge(d.count));
    </script>
    @yield('scripts')
</body>
</html>
