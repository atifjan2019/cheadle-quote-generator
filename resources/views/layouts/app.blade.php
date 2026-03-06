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
            </a>

            <!-- Hamburger (mobile) -->
            <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileMenu()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>

            <nav class="navbar-nav" id="navbarNav">
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
            </div>
        </div>
    </header>

    <!-- ══════════════ TOAST CONTAINER ════════ -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- ══════════════ MAIN ══════════════════ -->

    @yield('content')

    <!-- ══════════════ DELETE MODAL ═══════════ -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                    <path d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <h3>Delete Quote?</h3>
            <p>This action cannot be undone. The quote and all its data will be permanently removed.</p>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <a href="#" class="btn btn-danger" id="deleteConfirmBtn">Yes, Delete</a>
            </div>
        </div>
    </div>

    <!-- ══════════════ BACK TO TOP ════════════ -->
    <button class="back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to top">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="18" height="18">
            <path d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const nav = document.getElementById('navbarNav');
            const btn = document.getElementById('hamburgerBtn');
            nav.classList.toggle('open');
            btn.classList.toggle('open');
        }

        // Close mobile menu on link click
        document.querySelectorAll('#navbarNav a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navbarNav').classList.remove('open');
                document.getElementById('hamburgerBtn').classList.remove('open');
            });
        });

        // Delete modal
        function confirmDelete(url) {
            const modal = document.getElementById('deleteModal');
            const btn = document.getElementById('deleteConfirmBtn');
            btn.href = url;
            modal.classList.add('show');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Toast notifications
        function showToast(message, type) {
            type = type || 'success';
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = 'toast toast-' + type;
            toast.innerHTML = '<span>' + message + '</span><button onclick="this.parentElement.remove()">✕</button>';
            container.appendChild(toast);
            setTimeout(function() { toast.classList.add('show'); }, 10);
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() { toast.remove(); }, 300);
            }, 4000);
        }

        // Back to top
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (!btn) return;
            if (window.scrollY > 400) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>