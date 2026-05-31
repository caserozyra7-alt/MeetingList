@extends('layouts.app')

@section('title', 'Meetings')

@push('styles')
<style>
    .meetings-toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 320px;
    }

    .search-box svg {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        width: 15px; height: 15px;
    }

    .search-input {
        width: 100%;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 9px 12px 9px 38px;
        font-size: 13px;
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.15s;
    }

    .search-input:focus { border-color: var(--accent); }
    .search-input::placeholder { color: var(--muted); }

    .filter-tabs {
        display: flex;
        gap: 4px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 3px;
    }

    .filter-tab {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        display: flex; align-items: center; gap: 6px;
    }

    .filter-tab:hover { color: var(--text); }
    .filter-tab.active { background: var(--surface-2); color: var(--text); }

    .filter-tab .count {
        background: var(--border);
        color: var(--muted);
        border-radius: 20px;
        padding: 1px 7px;
        font-size: 10px;
    }

    .filter-tab.active .count {
        background: rgba(61,107,82,0.15);
        color: var(--accent);
    }

    .view-toggle {
        display: flex;
        gap: 2px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 3px;
    }

    .view-btn {
        width: 32px; height: 32px;
        border-radius: 5px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--muted);
        transition: background 0.15s, color 0.15s;
        border: none;
        background: transparent;
    }

    .view-btn svg { width: 15px; height: 15px; }
    .view-btn:hover { color: var(--text); }
    .view-btn.active { background: var(--surface-2); color: var(--text); }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .stat-icon svg {
        width: 20px !important;
        height: 20px !important;
        min-width: 20px;
        min-height: 20px;
        max-width: 20px;
        max-height: 20px;
        display: block;
        flex-shrink: 0;
    }

    .stat-card-value { font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
    .stat-card-label { font-size: 12px; color: var(--muted); margin-top: 2px; }

    .meetings-table-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }

    thead th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        text-align: left;
        background: var(--surface-2);
        white-space: nowrap;
    }

    thead th:first-child { padding-left: 24px; }
    thead th:last-child { padding-right: 24px; text-align: right; }

    .sortable { cursor: pointer; user-select: none; }
    .sortable:hover { color: var(--text); }
    .sortable svg { width: 10px; height: 10px; display: inline; margin-left: 4px; }

    tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.1s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(0,0,0,0.01); }

    tbody td {
        padding: 14px 16px;
        font-size: 13px;
        vertical-align: middle;
    }

    tbody td:first-child { padding-left: 24px; }
    tbody td:last-child { padding-right: 24px; text-align: right; }

    .meeting-title-cell { display: flex; align-items: center; gap: 12px; }

    .meeting-color-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .meeting-title-text { font-weight: 500; }
    .meeting-organizer { font-size: 11px; color: var(--muted); margin-top: 2px; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-upcoming  { background:rgba(61,107,82,0.1);  color:var(--accent); border:1px solid rgba(61,107,82,0.2); }
    .status-ongoing   { background:rgba(212,130,26,0.12); color:#d4821a; border:1px solid rgba(212,130,26,0.2); }
    .status-completed { background:rgba(52,201,138,0.12); color:#34c98a; border:1px solid rgba(52,201,138,0.2); }
    .status-cancelled { background:rgba(122,128,160,0.12); color:var(--muted); border:1px solid rgba(122,128,160,0.2); }

    .date-cell { white-space: nowrap; }
    .date-main { font-weight: 500; }
    .date-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

    .action-menu { display: inline-flex; align-items: center; gap: 4px; }

    .icon-btn {
        width: 30px; height: 30px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--muted);
        background: transparent;
        border: 1px solid transparent;
        transition: background 0.12s, color 0.12s, border-color 0.12s;
        text-decoration: none;
    }

    .icon-btn:hover { background: var(--surface-2); border-color: var(--border); color: var(--text); }
    .icon-btn.danger:hover { background: rgba(185,64,64,0.08); border-color: rgba(185,64,64,0.3); color: var(--danger); }
    .icon-btn svg { width: 14px; height: 14px; }

    .empty-state {
        text-align: center;
        padding: 64px 24px;
    }

    .empty-icon {
        width: 64px; height: 64px;
        margin: 0 auto 20px;
        background: var(--surface-2);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted);
        overflow: hidden;
        flex-shrink: 0;
    }

    .empty-icon svg {
        width: 28px !important;
        height: 28px !important;
        min-width: 28px;
        min-height: 28px;
        max-width: 28px;
        max-height: 28px;
        display: block;
        flex-shrink: 0;
    }

    .empty-title { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
    .empty-sub { font-size: 13px; color: var(--muted); margin-bottom: 20px; }

    .meetings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
    }

    .meeting-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        transition: border-color 0.15s, transform 0.15s;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .meeting-card:hover { border-color: rgba(61,107,82,0.3); transform: translateY(-1px); }

    .meeting-card-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
    .meeting-card-title { font-weight: 600; font-size: 14px; line-height: 1.4; }
    .meeting-card-meta { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }
    .meeting-card-meta svg {
        width: 13px !important;
        height: 13px !important;
        min-width: 13px;
        max-width: 13px;
        flex-shrink: 0;
        display: block;
    }
    .meeting-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid var(--border); }

    .pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px;
        border-top: 1px solid var(--border);
        font-size: 12px;
        color: var(--muted);
    }

    .pagination-pages { display: flex; gap: 4px; }

    .page-btn {
        width: 30px; height: 30px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 500;
        text-decoration: none;
        color: var(--muted);
        transition: background 0.12s, color 0.12s;
    }

    .page-btn svg { width: 14px; height: 14px; }
    .page-btn:hover { background: var(--surface-2); color: var(--text); }
    .page-btn.active { background: var(--accent); color: #fff; }
    .page-btn.disabled { opacity: 0.4; pointer-events: none; }

    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px;
        border-radius: 8px; font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; border: none;
        transition: opacity 0.15s, transform 0.1s;
        text-decoration: none;
    }
    .btn svg { width: 14px; height: 14px; }
    .btn:active { transform: scale(0.98); }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-primary:hover { opacity: 0.88; }
    .btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--muted); }
    .btn-ghost:hover { border-color: var(--text); color: var(--text); }

    .hidden { display: none !important; }

    @media (max-width: 900px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .meetings-toolbar { flex-direction: column; align-items: stretch; }
        .search-box { max-width: 100%; }
    }
</style>
@endpush

@section('topbar-actions')
    <a href="{{ route('meetings.create') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;border:none;background:var(--accent);color:#fff;text-decoration:none;">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        New Meeting
    </a>
@endsection

@section('content')

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(61,107,82,0.1);color:var(--accent);">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div>
            <div class="stat-card-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-card-label">Total Meetings</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(61,107,82,0.1);color:var(--accent);">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="stat-card-value">{{ $stats['upcoming'] ?? 0 }}</div>
            <div class="stat-card-label">Upcoming</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(212,130,26,0.12);color:#d4821a;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4l3 3"/></svg>
        </div>
        <div>
            <div class="stat-card-value">{{ $stats['ongoing'] ?? 0 }}</div>
            <div class="stat-card-label">Ongoing</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(52,201,138,0.12);color:#34c98a;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="stat-card-value">{{ $stats['completed'] ?? 0 }}</div>
            <div class="stat-card-label">Completed</div>
        </div>
    </div>
</div>

<div class="meetings-toolbar">
    <div class="search-box">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input class="search-input" type="text" id="search-input" placeholder="Search meetings…" value="{{ request('search') }}" oninput="liveSearch(this.value)">
    </div>

    <div class="filter-tabs">
        <a href="{{ route('meetings.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
            All <span class="count">{{ $stats['total'] ?? 0 }}</span>
        </a>
        <a href="{{ route('meetings.index', ['status' => 'upcoming']) }}" class="filter-tab {{ request('status') === 'upcoming' ? 'active' : '' }}">
            Upcoming <span class="count">{{ $stats['upcoming'] ?? 0 }}</span>
        </a>
        <a href="{{ route('meetings.index', ['status' => 'ongoing']) }}" class="filter-tab {{ request('status') === 'ongoing' ? 'active' : '' }}">
            Ongoing <span class="count">{{ $stats['ongoing'] ?? 0 }}</span>
        </a>
        <a href="{{ route('meetings.index', ['status' => 'completed']) }}" class="filter-tab {{ request('status') === 'completed' ? 'active' : '' }}">
            Done <span class="count">{{ $stats['completed'] ?? 0 }}</span>
        </a>
        <a href="{{ route('meetings.index', ['status' => 'cancelled']) }}" class="filter-tab {{ request('status') === 'cancelled' ? 'active' : '' }}">
            Cancelled
        </a>
    </div>

    <div class="view-toggle" style="margin-left:auto;">
        <button class="view-btn active" id="btn-table" onclick="switchView('table')" title="Table view">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/></svg>
        </button>
        <button class="view-btn" id="btn-grid" onclick="switchView('grid')" title="Card view">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        </button>
    </div>
</div>

<div id="search-empty-state" class="meetings-table-wrap hidden">
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="empty-title">No meetings found</div>
        <div class="empty-sub" id="search-empty-msg">No meetings match your criteria.</div>
    </div>
</div>

@if($meetings->count())
<div id="view-table">
    <div class="meetings-table-wrap" id="main-table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="sortable" onclick="sortTable(0)">
                        Title <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 9l4-4 4 4M8 15l4 4 4-4"/></svg>
                    </th>
                    <th>Status</th>
                    <th class="sortable" onclick="sortTable(2)">
                        Date & Time <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 9l4-4 4 4M8 15l4 4 4-4"/></svg>
                    </th>
                    <th>Duration</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="meetings-tbody">
                @foreach($meetings as $meeting)
                @php
                    $colors = ['#4f8ef7','#7c5cfc','#34c98a','#f5a623','#f74f6a','#60d4b0'];
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <tr data-title="{{ strtolower($meeting->title) }}" data-date="{{ $meeting->start_time }}">
                    <td>
                        <div class="meeting-title-cell">
                            <div class="meeting-color-dot" style="background:{{ $color }}"></div>
                            <div>
                                <div class="meeting-title-text">{{ $meeting->title }}</div>
                                <div class="meeting-organizer">{{ $meeting->organizer ?? auth()->user()->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $meeting->status ?? 'upcoming' }}">
                            {{ ucfirst($meeting->status ?? 'upcoming') }}
                        </span>
                    </td>
                    <td class="date-cell">
                        <div class="date-main">{{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }}</div>
                        <div class="date-sub">{{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}</div>
                    </td>
                    <td style="color:var(--muted);font-size:12px;">
                        @if($meeting->end_time)
                            {{ \Carbon\Carbon::parse($meeting->start_time)->diffInMinutes($meeting->end_time) }} min
                        @else —
                        @endif
                    </td>
                    <td style="font-size:12px;color:var(--muted);max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $meeting->location ?? '—' }}
                    </td>
                    <td>
                        <div class="action-menu">
                            <a href="{{ route('meetings.show', $meeting->id) }}" class="icon-btn" title="View">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('meetings.edit', $meeting->id) }}" class="icon-btn" title="Edit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('meetings.destroy', $meeting->id) }}" onsubmit="return confirmDelete(event, '{{ addslashes($meeting->title) }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="icon-btn danger" title="Delete">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination" id="table-pagination">
            <span>Showing {{ $meetings->firstItem() }}–{{ $meetings->lastItem() }} of {{ $meetings->total() }} meetings</span>
            <div class="pagination-pages">
                <a href="{{ $meetings->previousPageUrl() }}" class="page-btn {{ $meetings->onFirstPage() ? 'disabled' : '' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                @foreach($meetings->getUrlRange(1, $meetings->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-btn {{ $meetings->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
                @endforeach
                <a href="{{ $meetings->nextPageUrl() }}" class="page-btn {{ !$meetings->hasMorePages() ? 'disabled' : '' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="view-grid" class="hidden">
    <div class="meetings-grid" id="meetings-grid">
        @foreach($meetings as $meeting)
        @php
            $colors = ['#4f8ef7','#7c5cfc','#34c98a','#f5a623','#f74f6a','#60d4b0'];
            $color = $colors[$loop->index % count($colors)];
        @endphp
        <div class="meeting-card" data-title="{{ strtolower($meeting->title) }}">
            <div class="meeting-card-header">
                <div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $color }};flex-shrink:0;"></div>
                        <span class="status-badge status-{{ $meeting->status ?? 'upcoming' }}">{{ ucfirst($meeting->status ?? 'upcoming') }}</span>
                    </div>
                    <div class="meeting-card-title">{{ $meeting->title }}</div>
                </div>
                <div class="action-menu">
                    <a href="{{ route('meetings.edit', $meeting->id) }}" class="icon-btn" title="Edit">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('meetings.destroy', $meeting->id) }}" onsubmit="return confirmDelete(event, '{{ addslashes($meeting->title) }}')">
                        @csrf @method('DELETE')
                        <button type="submit" class="icon-btn danger" title="Delete">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($meeting->description)
            <div style="font-size:12px;color:var(--muted);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                {{ $meeting->description }}
            </div>
            @endif

            <div style="display:flex;flex-direction:column;gap:6px;">
                <div class="meeting-card-meta">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y · h:i A') }}
                </div>
                @if($meeting->location)
                <div class="meeting-card-meta">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $meeting->location }}
                </div>
                @endif
                @if($meeting->end_time)
                <div class="meeting-card-meta">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 16 14"/></svg>
                    {{ \Carbon\Carbon::parse($meeting->start_time)->diffInMinutes($meeting->end_time) }} min
                </div>
                @endif
            </div>

            <div class="meeting-card-footer">
                <div style="font-size:11px;color:var(--muted);">By {{ $meeting->organizer ?? auth()->user()->name }}</div>
                <a href="{{ route('meetings.show', $meeting->id) }}" style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;font-size:12px;background:var(--surface-2);color:var(--text);border:1px solid var(--border);border-radius:8px;text-decoration:none;">
                    View <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@else
<div class="meetings-table-wrap">
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="empty-title">No meetings found</div>
        <div class="empty-sub">
            @if(request('status'))
                No {{ request('status') }} meetings yet
            @else
                Schedule your first meeting to get started
            @endif
        </div>
        <a href="{{ route('meetings.create') }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;border:none;background:var(--accent);color:#fff;text-decoration:none;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            New Meeting
        </a>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
let currentView = 'table';

function switchView(v) {
    currentView = v;
    const table = document.getElementById('view-table');
    const grid  = document.getElementById('view-grid');
    const btnT  = document.getElementById('btn-table');
    const btnG  = document.getElementById('btn-grid');
    const isEmpty = !document.getElementById('search-empty-state').classList.contains('hidden');

    if (v === 'table') {
        if(table && !isEmpty) table.classList.remove('hidden');
        if(grid) grid.classList.add('hidden');
        if(btnT) btnT.classList.add('active');
        if(btnG) btnG.classList.remove('active');
    } else {
        if(grid && !isEmpty) grid.classList.remove('hidden');
        if(table) table.classList.add('hidden');
        if(btnG) btnG.classList.add('active');
        if(btnT) btnT.classList.remove('active');
    }
    localStorage.setItem('meetingView', v);
}

(function() {
    const saved = localStorage.getItem('meetingView');
    if (saved === 'grid') switchView('grid');
    else switchView('table');
})();

function liveSearch(query) {
    const q = query.toLowerCase().trim();
    let tableMatchCount = 0;
    let gridMatchCount = 0;

    const tableRows = document.querySelectorAll('#meetings-tbody tr');
    const gridCards = document.querySelectorAll('#meetings-grid .meeting-card');
    const tableContainer = document.getElementById('view-table');
    const gridContainer  = document.getElementById('view-grid');
    const pagination     = document.getElementById('table-pagination');
    const emptyState     = document.getElementById('search-empty-state');
    const emptyMsg       = document.getElementById('search-empty-msg');

    tableRows.forEach(row => {
        const title = row.dataset.title || '';
        if (!q || title.includes(q)) { row.style.display = ''; tableMatchCount++; }
        else row.style.display = 'none';
    });

    gridCards.forEach(card => {
        const title = card.dataset.title || '';
        if (!q || title.includes(q)) { card.style.display = ''; gridMatchCount++; }
        else card.style.display = 'none';
    });

    const totalMatches = (currentView === 'table') ? tableMatchCount : gridMatchCount;

    if (q.length > 0) {
        if (pagination) pagination.classList.add('hidden');
        if (totalMatches === 0) {
            if (tableContainer) tableContainer.classList.add('hidden');
            if (gridContainer)  gridContainer.classList.add('hidden');
            if (emptyState) { emptyState.classList.remove('hidden'); emptyMsg.textContent = `No meetings match "${query}".`; }
        } else {
            if (emptyState) emptyState.classList.add('hidden');
            if (currentView === 'table' && tableContainer) tableContainer.classList.remove('hidden');
            if (currentView === 'grid'  && gridContainer)  gridContainer.classList.remove('hidden');
        }
    } else {
        if (pagination) pagination.classList.remove('hidden');
        if (emptyState) emptyState.classList.add('hidden');
        if (currentView === 'table') {
            if (tableContainer) tableContainer.classList.remove('hidden');
            if (gridContainer)  gridContainer.classList.add('hidden');
        } else {
            if (gridContainer)  gridContainer.classList.remove('hidden');
            if (tableContainer) tableContainer.classList.add('hidden');
        }
    }
}

function confirmDelete(e, title) {
    if (!confirm(`Delete "${title}"?\n\nThis action cannot be undone.`)) {
        e.preventDefault();
        return false;
    }
    return true;
}

let sortDir = {};
function sortTable(col) {
    const tbody = document.getElementById('meetings-tbody');
    if (!tbody) return;
    const rows = Array.from(tbody.querySelectorAll('tr'));
    sortDir[col] = !sortDir[col];
    rows.sort((a, b) => {
        const aVal = a.cells[col]?.textContent.trim() || '';
        const bVal = b.cells[col]?.textContent.trim() || '';
        return sortDir[col] ? aVal.localeCompare(bVal, undefined, {numeric:true}) : bVal.localeCompare(aVal, undefined, {numeric:true});
    });
    rows.forEach(r => tbody.appendChild(r));
}
</script>
@endpush