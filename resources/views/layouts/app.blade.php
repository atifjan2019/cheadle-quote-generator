<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cheadle Construction Quote Generator')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>

<body class="@yield('body-class')">

    <!-- ══════════════ TOP NAVBAR ══════════════ -->
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('quotes.index') }}" class="navbar-brand">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                <div class="brand-name">Cheadle <span>Construction</span></div>
            </a>

            <nav class="navbar-nav">
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
                <a href="{{ route('quotes.list') }}" class="@yield('nav-quotes')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" />
                    </svg>
                    All Quotes
                </a>
                <a href="{{ route('quotes.form') }}" class="@yield('nav-form')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <path d="M14 2v6h6M12 11v6M9 14h6" />
                    </svg>
                    @yield('nav-form-label', 'New Quote')
                </a>
            </nav>

            <div class="navbar-actions">
                <a href="{{ route('quotes.form') }}" class="btn btn-primary btn-sm">+ New Quote</a>
                <a href="#" class="navbar-help" title="Help">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="18" height="18">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- ══════════════ MAIN ══════════════════ -->

    @yield('content')

    @stack('scripts')
</body>

</html>