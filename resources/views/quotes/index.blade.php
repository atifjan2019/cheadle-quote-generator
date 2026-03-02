@extends('layouts.app')

@section('title', 'Dashboard — Cheadle Construction Quote Generator')
@section('body-class', 'page-dashboard')
@section('nav-dashboard', 'active')
@if($total > 0)
@section('badge-count', $total)
@endif

@section('content')
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-search">
                <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="searchInput" placeholder="Search quotes..." onkeyup="filterTable()">
                <span class="search-kbd">⌘F</span>
            </div>

            <div class="topbar-icons">
                <a href="{{ route('quotes.form') }}" class="topbar-icon-btn" title="New Quote">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </a>
                <button class="topbar-icon-btn" title="Notifications" onclick="void(0)">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                    </svg>
                </button>
            </div>

            <div class="topbar-user">
                <div class="topbar-avatar">JF</div>
                <div>
                    <div class="user-name">Joanne Fowler</div>
                    <div class="user-role">Cheadle Construction</div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="page-content">

            @if($msg === 'saved')
                <div class="alert alert-success">✅ Quote saved successfully.</div>
            @elseif($msg === 'deleted')
                <div class="alert alert-success">🗑️ Quote deleted successfully.</div>
            @endif

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Dashboard</h1>
                    <p>Manage, generate and track all Cheadle Construction quotes.</p>
                </div>
                <div class="page-header-actions">
                    <a href="{{ route('quotes.form') }}" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="15"
                            height="15">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        New Quote
                    </a>
                    <a href="#all-quotes" class="btn btn-outline">View All</a>
                </div>
            </div>

            <!-- STATS ROW -->
            <div class="stats-grid">
                <div class="stat-card featured">
                    <div class="stat-label">
                        Total Quotes
                        <a href="{{ route('quotes.form') }}" class="stat-arrow" title="New Quote">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13"
                                height="13">
                                <path d="M7 17L17 7M7 7h10v10" />
                            </svg>
                        </a>
                    </div>
                    <div class="stat-value">{{ $total }}</div>
                    <div class="stat-trend">
                        <span class="trend-icon-wrap">↑</span>
                        All time quotes created
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Drafts
                        <a href="#all-quotes" class="stat-arrow">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13"
                                height="13">
                                <path d="M7 17L17 7M7 7h10v10" />
                            </svg>
                        </a>
                    </div>
                    <div class="stat-value">{{ $draft }}</div>
                    <div class="stat-trend">
                        <span class="trend-icon-wrap" style="background:#f1f5f9;color:#64748b;">≡</span>
                        In progress
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Sent to Client
                        <a href="#all-quotes" class="stat-arrow">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13"
                                height="13">
                                <path d="M7 17L17 7M7 7h10v10" />
                            </svg>
                        </a>
                    </div>
                    <div class="stat-value">{{ $sent }}</div>
                    <div class="stat-trend">
                        <span class="trend-icon-wrap" style="background:#dbeafe;color:#1d4ed8;">→</span>
                        Awaiting response
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">
                        Accepted
                        <a href="#all-quotes" class="stat-arrow">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="13"
                                height="13">
                                <path d="M7 17L17 7M7 7h10v10" />
                            </svg>
                        </a>
                    </div>
                    <div class="stat-value">{{ $accepted }}</div>
                    <div class="stat-trend">
                        <span class="trend-icon-wrap" style="background:#dcfce7;color:#16a34a;">✓</span>
                        Won projects
                    </div>
                </div>
            </div>

            <!-- Content grid -->
            <div class="content-grid">

                <!-- LEFT: Main quote table -->
                <div class="left">
                    <!-- Quote analytics mini chart -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Quote Activity</h2>
                            <span style="font-size:12px;color:var(--text-muted);">Last 7 months</span>
                        </div>
                        <div class="card-body" style="padding-bottom:10px;">
                            <div style="display:flex;align-items:flex-end;gap:10px;height:90px;">
                                @php $maxBar = max(array_merge($bars, [1])); @endphp
                                @foreach($bars as $i => $val)
                                    @php $h = $maxBar > 0 ? max(10, round(($val / $maxBar) * 80)) : 10; @endphp
                                    <div class="bar-col">
                                        <div class="bar {{ $val > 0 ? ($i === count($bars) - 1 ? 'filled' : 'mid') : '' }}"
                                            style="height:{{ $h }}px;"></div>
                                        <span class="day-label">{{ $months[$i] }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @if($totalValue > 0)
                                <div
                                    style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:12px;color:var(--text-muted);">Total pipeline value (all
                                        accepted/sent)</span>
                                    <strong
                                        style="font-size:15px;color:var(--brand-red);">£{{ number_format($totalValue, 0) }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- All quotes table -->
                    <div class="card" id="all-quotes">
                        <div class="card-header">
                            <h2>All Quotes</h2>
                            <a href="{{ route('quotes.form') }}" class="btn btn-primary btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="13"
                                    height="13">
                                    <path d="M12 5v14M5 12h14" />
                                </svg>
                                Add Quote
                            </a>
                        </div>

                        @if($quotes->isEmpty())
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" />
                                </svg>
                                <h3>No quotes yet</h3>
                                <p>Click "New Quote" to create your first quote.</p>
                                <a href="{{ route('quotes.form') }}" class="btn btn-primary">Create First Quote</a>
                            </div>
                        @else
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotes as $q)
                                            <tr>
                                                <td><strong style="color:var(--brand-red);">{{ $q->project_ref }}</strong></td>
                                                <td>
                                                    <div style="display:flex;align-items:center;gap:8px;">
                                                        <div
                                                            style="width:28px;height:28px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--brand-navy);">
                                                            {{ strtoupper(substr($q->client_name, 0, 1)) }}
                                                        </div>
                                                        {{ $q->client_name }}
                                                    </div>
                                                </td>
                                                <td style="color:var(--text-muted);">
                                                    {{ \Carbon\Carbon::parse($q->date)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $q->prepared_by }}</td>
                                                <td><strong>{!! $q->total_cost ? '£' . number_format($q->total_cost, 0) : '<span style="color:var(--text-label)">—</span>' !!}</strong>
                                                </td>
                                                <td><span class="badge badge-{{ $q->status }}">{{ ucfirst($q->status) }}</span></td>
                                                <td>
                                                    <div style="display:flex;gap:6px;">
                                                        <a href="{{ route('quotes.form', ['id' => $q->id]) }}"
                                                            class="btn btn-outline btn-sm btn-icon" title="Edit">
                                                            <svg fill="none" stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" width="14" height="14">
                                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('quotes.pdf', ['id' => $q->id]) }}"
                                                            class="btn btn-primary btn-sm btn-icon" title="Download PDF"
                                                            target="_blank">
                                                            <svg fill="none" stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" width="14" height="14">
                                                                <path
                                                                    d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                                                            </svg>
                                                        </a>
                                                        <a href="{{ route('quotes.delete', ['id' => $q->id]) }}"
                                                            class="btn btn-danger btn-sm btn-icon" title="Delete"
                                                            onclick="return confirm('Delete this quote? This cannot be undone.')">
                                                            <svg fill="none" stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" width="14" height="14">
                                                                <polyline points="3 6 5 6 21 6" />
                                                                <path
                                                                    d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- RIGHT: Recent quotes + quick actions -->
                <div class="right">
                    @php
                        $iconColours = ['#ffe4e8', '#dbeafe', '#dcfce7', '#fef3c7', '#f3e8ff'];
                        $iconEmojis = ['🏗️', '🏠', '🔨', '🏢', '⚒️'];
                    @endphp

                    <!-- Recent 5 quotes -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Recent Quotes</h2>
                            <a href="{{ route('quotes.form') }}" class="btn btn-outline btn-sm"
                                style="border-radius:20px;padding:5px 12px;font-size:12px;">+ New</a>
                        </div>
                        <div class="card-body" style="padding:8px 22px;">
                            @if($recent5->isEmpty())
                                <p style="text-align:center;padding:20px;color:var(--text-muted);font-size:13px;">No quotes yet.
                                </p>
                            @else
                                <div class="quote-list">
                                    @foreach($recent5 as $i => $q)
                                        <a href="{{ route('quotes.form', ['id' => $q->id]) }}" class="quote-item">
                                            <div class="quote-item-icon"
                                                style="background:{{ $iconColours[$i % count($iconColours)] }};">
                                                {{ $iconEmojis[$i % count($iconEmojis)] }}
                                            </div>
                                            <div class="quote-item-info">
                                                <div class="ref">{{ $q->project_ref }}</div>
                                                <div class="due">{{ $q->client_name }} ·
                                                    {{ \Carbon\Carbon::parse($q->date)->format('d M Y') }}
                                                </div>
                                            </div>
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14"
                                                height="14" class="quote-item-chevron">
                                                <path d="M9 18l6-6-6-6" />
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status summary -->
                    <div class="card">
                        <div class="card-header">
                            <h2>Status Summary</h2>
                        </div>
                        <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">
                            @php
                                $statuses = [
                                    ['draft', 'Drafts', $draft, '#f1f5f9', '#64748b'],
                                    ['sent', 'Sent', $sent, '#dbeafe', '#1d4ed8'],
                                    ['accepted', 'Accepted', $accepted, '#dcfce7', '#16a34a'],
                                    ['declined', 'Declined', $declined, '#fee2e2', '#dc2626'],
                                ];
                            @endphp
                            @foreach($statuses as [$s, $label, $count, $bg, $clr])
                                @php $pct = $total > 0 ? round(($count / $total) * 100) : 0; @endphp
                                <div>
                                    <div
                                        style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                        <span
                                            style="font-size:12px;font-weight:600;color:var(--text-muted);">{{ $label }}</span>
                                        <span style="font-size:12px;font-weight:700;color:{{ $clr }};">{{ $count }}</span>
                                    </div>
                                    <div style="height:6px;background:var(--border);border-radius:10px;overflow:hidden;">
                                        <div
                                            style="height:100%;width:{{ $pct }}%;background:{{ $clr }};border-radius:10px;transition:width 0.6s ease;">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        function filterTable() {
            const val = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#quoteTable tbody tr');
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
            });
        }

        // Animate stat values
        document.querySelectorAll('.stat-value').forEach(el => {
            const target = parseInt(el.textContent.trim()) || 0;
            let current = 0;
            if (target === 0) return;
            const step = Math.ceil(target / 20);
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = current;
                if (current >= target) clearInterval(timer);
            }, 40);
        });
    </script>
@endpush