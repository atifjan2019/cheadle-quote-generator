<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cheadle Construction Quote Generator')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="@yield('body-class')">

    <!-- ══════════════ SIDEBAR ══════════════ -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            <div class="brand-name">Cheadle <span>Construction</span></div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu</div>
            <a href="{{ route('quotes.index') }}" class="@yield('nav-dashboard')">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
                Dashboard
                @hasSection('badge-count')
                    <span class="badge-count">@yield('badge-count')</span>
                @endif
            </a>
            <a href="{{ route('quotes.form') }}" class="@yield('nav-form')">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <path d="M14 2v6h6M12 11v6M9 14h6" />
                </svg>
                @yield('nav-form-label', 'New Quote')
            </a>
            <div class="nav-section-label">General</div>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14" />
                </svg>
                Settings
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01" />
                </svg>
                Help
            </a>
        </nav>

        <div class="sidebar-promo">
            <div class="promo-icon">
                <svg fill="none" stroke="#c8102e" stroke-width="2" viewBox="0 0 24 24" width="20" height="20">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <path d="M14 2v6h6" />
                </svg>
            </div>
            @section('sidebar-promo-content')
            <h4>Quick Quote</h4>
            <p>Create a new branded PDF quote in minutes</p>
            <a href="{{ route('quotes.form') }}">+ New Quote</a>
            @show
        </div>
    </aside>

    <!-- ══════════════ MAIN ══════════════════ -->

    @yield('content')

    @stack('scripts')
</body>

</html>