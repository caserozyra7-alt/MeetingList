@extends('layouts.app')
 
@section('title', 'Meeting Details')
 
@section('topbar-actions')
    <a href="{{ route('meetings.index') }}" class="btn btn-ghost" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer;border:1px solid var(--border);color:var(--ink-2);text-decoration:none;background:transparent;">
        <i class="bi bi-arrow-left"></i> Back
    </a>
@endsection
 
@section('content')
<style>
    .detail-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        max-width: 720px;
        overflow: hidden;
    }
 
    .detail-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
 
    .detail-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 6px;
    }
 
    .detail-organizer {
        font-size: 0.82rem;
        color: var(--ink-3);
    }
 
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
 
    .status-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
 
    .status-upcoming  { background:rgba(61,107,82,0.1);  color:var(--accent); border:1px solid rgba(61,107,82,0.2); }
    .status-ongoing   { background:rgba(212,130,26,0.12); color:#d4821a; border:1px solid rgba(212,130,26,0.2); }
    .status-completed { background:rgba(52,201,138,0.12); color:#34c98a; border:1px solid rgba(52,201,138,0.2); }
    .status-cancelled { background:rgba(185,64,64,0.1);  color:var(--danger); border:1px solid rgba(185,64,64,0.2); }
 
    .detail-body { padding: 1.5rem; }
 
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }
 
    .detail-item-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--ink-3);
        margin-bottom: 4px;
    }
 
    .detail-item-value {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--ink);
    }
 
    .detail-description {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1rem;
        font-size: 0.875rem;
        color: var(--ink-2);
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }
 
    .detail-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        background: var(--bg);
    }
 
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.25rem;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.18s;
    }
 
    .btn-primary:hover { background: var(--accent-hover); }
 
    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.1rem;
        background: none;
        color: var(--danger);
        border: 1.5px solid var(--danger-border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }
 
    .btn-danger:hover { background: var(--danger-bg); }
 
    @media (max-width: 600px) {
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
 
<div class="detail-card">
    <div class="detail-header">
        <div>
            <div class="detail-title">{{ $meeting->title }}</div>
            <div class="detail-organizer">
                <i class="bi bi-person"></i> Organized by {{ $meeting->organizer ?? auth()->user()->name }}
            </div>
        </div>
        <span class="status-badge status-{{ $meeting->status ?? 'upcoming' }}">
            {{ ucfirst($meeting->status ?? 'upcoming') }}
        </span>
    </div>
 
    <div class="detail-body">
 
        @if($meeting->description)
        <div class="detail-description">
            {{ $meeting->description }}
        </div>
        @endif
 
        <div class="detail-grid">
            <div>
                <div class="detail-item-label"><i class="bi bi-calendar3"></i> Start Time</div>
                <div class="detail-item-value">
                    {{ \Carbon\Carbon::parse($meeting->start_time)->format('F d, Y') }}<br>
                    <span style="color:var(--ink-3);font-size:0.82rem;">
                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}
                    </span>
                </div>
            </div>
            <div>
                <div class="detail-item-label"><i class="bi bi-calendar-check"></i> End Time</div>
                <div class="detail-item-value">
                    @if($meeting->end_time)
                        {{ \Carbon\Carbon::parse($meeting->end_time)->format('F d, Y') }}<br>
                        <span style="color:var(--ink-3);font-size:0.82rem;">
                            {{ \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') }}
                        </span>
                    @else
                        <span style="color:var(--ink-3);">Not set</span>
                    @endif
                </div>
            </div>
            <div>
                <div class="detail-item-label"><i class="bi bi-geo-alt"></i> Location</div>
                <div class="detail-item-value">{{ $meeting->location ?? '—' }}</div>
            </div>
            <div>
                <div class="detail-item-label"><i class="bi bi-clock"></i> Duration</div>
                <div class="detail-item-value">
                    @if($meeting->end_time)
                        {{ \Carbon\Carbon::parse($meeting->start_time)->diffInMinutes($meeting->end_time) }} minutes
                    @else
                        <span style="color:var(--ink-3);">—</span>
                    @endif
                </div>
            </div>
        </div>
 
    </div>
 
    <div class="detail-footer">
        <a href="{{ route('meetings.edit', $meeting->id) }}" class="btn-primary">
            <i class="bi bi-pencil"></i> Edit Meeting
        </a>
        <form method="POST" action="{{ route('meetings.destroy', $meeting->id) }}"
            onsubmit="return confirm('Delete this meeting? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
@endsection