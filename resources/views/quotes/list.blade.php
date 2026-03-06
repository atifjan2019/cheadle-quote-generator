@extends('layouts.app')

@section('title', 'All Quotes — Cheadle Construction')
@section('body-class', 'page-dashboard')
@section('nav-quotes', 'active')

@section('content')
    <main class="main">

        <!-- Page content -->
        <div class="page-content">

            @if(session('msg') === 'saved' || request()->query('msg') === 'saved')
                <div class="alert alert-success">✅ Quote saved successfully.</div>
            @elseif(session('msg') === 'deleted' || request()->query('msg') === 'deleted')
                <div class="alert alert-success">🗑️ Quote deleted successfully.</div>
            @endif

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>All Quotes</h1>
                    <p>Browse, filter and manage every quote created or auto-saved.</p>
                </div>
                <div class="page-header-actions">
                    <div class="search-box-inline">
                        <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        <form id="searchForm" action="{{ route('quotes.list') }}" method="GET" style="display:contents;">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <input type="text" id="searchInput" name="search" value="{{ e($search) }}"
                                placeholder="Search quotes..."
                                onkeydown="if(event.key==='Enter'){this.form.submit();}">
                        </form>
                    </div>
                    <a href="{{ route('quotes.form') }}" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="15"
                            height="15">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        New Quote
                    </a>
                </div>
            </div>

            <!-- Filter & Sort Bar -->
            <div class="ql-toolbar">
                <div class="ql-filters">
                    @php
                        $filters = [
                            ['all', 'All', $allCount, '#1a1a2e'],
                            ['draft', 'Drafts', $draftCount, '#64748b'],
                            ['sent', 'Sent', $sentCount, '#1d4ed8'],
                            ['accepted', 'Accepted', $acceptedCount, '#16a34a'],
                            ['declined', 'Declined', $declinedCount, '#dc2626'],
                        ];
                    @endphp
                    @foreach($filters as [$key, $label, $count, $clr])
                        <a href="{{ route('quotes.list', ['status' => $key, 'search' => $search, 'sort' => $sort]) }}"
                           class="ql-filter-pill {{ $status === $key ? 'active' : '' }}"
                           style="{{ $status === $key ? 'background:' . $clr . ';color:#fff;border-color:' . $clr : '' }}">
                            {{ $label }}
                            <span class="ql-pill-count">{{ $count }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="ql-controls">
                    <!-- Sort dropdown -->
                    <div class="ql-sort-wrap">
                        <select id="sortSelect" onchange="applySort(this.value)">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Client A-Z</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Client Z-A</option>
                            <option value="value_high" {{ $sort === 'value_high' ? 'selected' : '' }}>Value High-Low</option>
                            <option value="value_low" {{ $sort === 'value_low' ? 'selected' : '' }}>Value Low-High</option>
                        </select>
                    </div>

                    <!-- View toggle -->
                    <div class="ql-view-toggle">
                        <button type="button" class="ql-view-btn active" id="viewGrid" onclick="setView('grid')" title="Card View">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16" height="16">
                                <rect x="3" y="3" width="7" height="7" rx="1"/>
                                <rect x="14" y="3" width="7" height="7" rx="1"/>
                                <rect x="3" y="14" width="7" height="7" rx="1"/>
                                <rect x="14" y="14" width="7" height="7" rx="1"/>
                            </svg>
                        </button>
                        <button type="button" class="ql-view-btn" id="viewList" onclick="setView('list')" title="List View">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16" height="16">
                                <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @if($search)
                <div class="ql-search-meta">
                    Showing results for "<strong>{{ e($search) }}</strong>"
                    <a href="{{ route('quotes.list', ['status' => $status, 'sort' => $sort]) }}" class="ql-clear-search">✕ Clear</a>
                </div>
            @endif

            <!-- Quotes Container -->
            @if($quotes->isEmpty())
                <div class="card" style="margin-top:8px;">
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                            <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" />
                        </svg>
                        <h3>No quotes found</h3>
                        @if($search)
                            <p>No quotes match "{{ e($search) }}". Try a different search term.</p>
                            <a href="{{ route('quotes.list') }}" class="btn btn-outline">Clear Search</a>
                        @elseif($status !== 'all')
                            <p>No {{ $status }} quotes yet.</p>
                            <a href="{{ route('quotes.list') }}" class="btn btn-outline">View All</a>
                        @else
                            <p>Click "New Quote" to create your first quote.</p>
                            <a href="{{ route('quotes.form') }}" class="btn btn-primary">Create First Quote</a>
                        @endif
                    </div>
                </div>
            @else
                <!-- GRID VIEW (default) -->
                <div class="ql-grid" id="quoteGrid">
                    @foreach($quotes as $q)
                        @php
                            $colors = [
                                'draft' => ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'accent' => '#64748b'],
                                'sent' => ['bg' => '#eff6ff', 'border' => '#bfdbfe', 'accent' => '#1d4ed8'],
                                'accepted' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'accent' => '#16a34a'],
                                'declined' => ['bg' => '#fef2f2', 'border' => '#fecaca', 'accent' => '#dc2626'],
                            ];
                            $c = $colors[$q->status] ?? $colors['draft'];
                            $initials = collect(explode(' ', $q->client_name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                            $timeAgo = \Carbon\Carbon::parse($q->created_at)->diffForHumans();
                        @endphp
                        <div class="ql-card" data-status="{{ $q->status }}">
                            <div class="ql-card-accent" style="background:{{ $c['accent'] }};"></div>
                            <div class="ql-card-top">
                                <div class="ql-card-ref">
                                    <span class="ql-ref-tag" style="background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }};color:{{ $c['accent'] }}">
                                        {{ $q->project_ref }}
                                    </span>
                                    <span class="badge badge-{{ $q->status }}">{{ ucfirst($q->status) }}</span>
                                </div>
                                <div class="ql-card-actions-dots" onclick="toggleCardMenu(this)">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="16" height="16">
                                        <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
                                    </svg>
                                    <div class="ql-card-dropdown">
                                        <a href="{{ route('quotes.form', ['id' => $q->id]) }}">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            Edit Quote
                                        </a>
                                        <a href="{{ route('quotes.pdf', ['id' => $q->id]) }}" target="_blank">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                            Download PDF
                                        </a>
                                        <a href="#" class="ql-action-danger" onclick="event.preventDefault();confirmDelete('{{ route('quotes.delete', ['id' => $q->id]) }}')">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="ql-card-client">
                                <div class="ql-card-avatar" style="background:{{ $c['accent'] }}20;color:{{ $c['accent'] }}">{{ $initials }}</div>
                                <div class="ql-card-client-info">
                                    <div class="ql-card-client-name">{{ $q->client_name }}</div>
                                    <div class="ql-card-client-meta">{{ $q->prepared_by }} · {{ \Carbon\Carbon::parse($q->date)->format('d M Y') }}</div>
                                </div>
                            </div>
                            @if($q->project_description)
                                <div class="ql-card-desc">{{ \Illuminate\Support\Str::limit($q->project_description, 100) }}</div>
                            @endif
                            <div class="ql-card-footer">
                                <div class="ql-card-value">
                                    @if($q->total_cost)
                                        <span class="ql-value-amount">£{{ number_format($q->total_cost, 0) }}</span>
                                        <span class="ql-value-label">inc. VAT</span>
                                    @else
                                        <span class="ql-value-none">No pricing</span>
                                    @endif
                                </div>
                                <div class="ql-card-time">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="12" height="12">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ $timeAgo }}
                                </div>
                            </div>
                            <div class="ql-card-actions-bar">
                                <a href="{{ route('quotes.form', ['id' => $q->id]) }}" class="ql-action-btn ql-action-edit">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <a href="{{ route('quotes.pdf', ['id' => $q->id]) }}" class="ql-action-btn ql-action-pdf" target="_blank">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                    PDF
                                </a>
                                <a href="#" class="ql-action-btn ql-action-del" onclick="event.preventDefault();confirmDelete('{{ route('quotes.delete', ['id' => $q->id]) }}')">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- LIST VIEW -->
                <div class="ql-list-view" id="quoteList" style="display:none;">
                    <div class="card">
                        <div class="table-wrap">
                            <table id="quoteTable">
                                <thead>
                                    <tr>
                                        <th>Project Ref</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Prepared By</th>
                                        <th>Total (inc. VAT)</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotes as $q)
                                        <tr>
                                            <td><strong style="color:var(--brand-red);">{{ $q->project_ref }}</strong></td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:8px;">
                                                    <div style="width:28px;height:28px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--brand-navy);">
                                                        {{ strtoupper(substr($q->client_name, 0, 1)) }}
                                                    </div>
                                                    {{ $q->client_name }}
                                                </div>
                                            </td>
                                            <td style="color:var(--text-muted);">
                                                {{ \Carbon\Carbon::parse($q->date)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $q->prepared_by }}</td>
                                            <td><strong>{!! $q->total_cost ? '£' . number_format($q->total_cost, 0) : '<span style="color:var(--text-label)">—</span>' !!}</strong></td>
                                            <td><span class="badge badge-{{ $q->status }}">{{ ucfirst($q->status) }}</span></td>
                                            <td style="color:var(--text-muted);font-size:12px;">{{ \Carbon\Carbon::parse($q->created_at)->diffForHumans() }}</td>
                                            <td>
                                                <div style="display:flex;gap:6px;">
                                                    <a href="{{ route('quotes.form', ['id' => $q->id]) }}" class="btn btn-outline btn-sm btn-icon" title="Edit">
                                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </a>
                                                    <a href="{{ route('quotes.pdf', ['id' => $q->id]) }}" class="btn btn-primary btn-sm btn-icon" title="Download PDF" target="_blank">
                                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon" title="Delete" onclick="confirmDelete('{{ route('quotes.delete', ['id' => $q->id]) }}')">
                                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Results count -->
                <div class="ql-results-count">
                    Showing <strong>{{ $quotes->count() }}</strong> quote{{ $quotes->count() !== 1 ? 's' : '' }}
                    @if($status !== 'all') · filtered by <strong>{{ $status }}</strong> @endif
                </div>
            @endif
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function applySort(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', val);
            window.location.href = url.toString();
        }

        function setView(mode) {
            const grid = document.getElementById('quoteGrid');
            const list = document.getElementById('quoteList');
            const btnGrid = document.getElementById('viewGrid');
            const btnList = document.getElementById('viewList');
            if (!grid || !list) return;

            if (mode === 'list') {
                grid.style.display = 'none';
                list.style.display = 'block';
                btnGrid.classList.remove('active');
                btnList.classList.add('active');
                localStorage.setItem('ql_view', 'list');
            } else {
                grid.style.display = '';
                list.style.display = 'none';
                btnGrid.classList.add('active');
                btnList.classList.remove('active');
                localStorage.setItem('ql_view', 'grid');
            }
        }

        function toggleCardMenu(el) {
            const dd = el.querySelector('.ql-card-dropdown');
            if (!dd) return;

            // Close all other open menus
            document.querySelectorAll('.ql-card-dropdown.open').forEach(d => {
                if (d !== dd) d.classList.remove('open');
            });

            dd.classList.toggle('open');
            event.stopPropagation();
        }

        // Close menus on click outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.ql-card-dropdown.open').forEach(d => d.classList.remove('open'));
        });

        // Restore view preference
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('ql_view');
            if (saved === 'list') setView('list');

            // Animate cards in
            const cards = document.querySelectorAll('.ql-card');
            cards.forEach((card, i) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(16px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50 + i * 60);
            });
        });
    </script>
@endpush
