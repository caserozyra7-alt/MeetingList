@extends('layouts.app')
 
@section('title', 'Edit Meeting')
 
@section('topbar-actions')
    <a href="{{ route('meetings.index') }}" class="btn btn-ghost" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer;border:1px solid var(--border);color:var(--ink-2);text-decoration:none;background:transparent;">
        <i class="bi bi-arrow-left"></i> Back
    </a>
@endsection
 
@section('content')
<style>
    .form-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        max-width: 720px;
    }
 
    .form-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }
 
    .form-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }
 
    .form-card-subtitle {
        font-size: 0.8rem;
        color: var(--ink-3);
        margin-top: 2px;
    }
 
    .form-card-body { padding: 1.5rem; }
 
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
 
    .form-row.full { grid-template-columns: 1fr; }
 
    .form-field { display: flex; flex-direction: column; }
 
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink-2);
        margin-bottom: 0.4rem;
    }
 
    .form-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        color: var(--ink);
        background: var(--card);
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s;
    }
 
    .form-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(61,107,82,0.12);
    }
 
    .form-input.is-invalid {
        border-color: var(--danger);
        background: var(--danger-bg);
    }
 
    textarea.form-input { resize: vertical; min-height: 100px; }
 
    .form-error {
        font-size: 0.775rem;
        color: var(--danger);
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
 
    .form-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        background: var(--bg);
        border-radius: 0 0 var(--radius) var(--radius);
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
        transition: background 0.18s;
    }
 
    .btn-primary:hover { background: var(--accent-hover); }
 
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        padding: 0.6rem 1.1rem;
        background: var(--card);
        color: var(--ink-2);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
    }
 
    .btn-cancel:hover { background: var(--border); }
 
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>
 
<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-title">Edit Meeting</div>
        <div class="form-card-subtitle">Update the details for "{{ $meeting->title }}"</div>
    </div>
 
    <form method="POST" action="{{ route('meetings.update', $meeting->id) }}">
        @csrf
        @method('PUT')
        <div class="form-card-body">
 
            <div class="form-row full">
                <div class="form-field">
                    <label class="form-label" for="title">Meeting Title <span style="color:var(--danger)">*</span></label>
                    <input class="form-input @error('title') is-invalid @enderror"
                        type="text" id="title" name="title"
                        value="{{ old('title', $meeting->title) }}"
                        placeholder="e.g. Q4 Planning Session" required>
                    @error('title')
                        <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
 
            <div class="form-row full">
                <div class="form-field">
                    <label class="form-label" for="description">
                        Description
                        <span style="font-weight:400;color:var(--ink-3);">(optional)</span>
                    </label>
                    <textarea class="form-input @error('description') is-invalid @enderror"
                        id="description" name="description"
                        placeholder="What is this meeting about?">{{ old('description', $meeting->description) }}</textarea>
                    @error('description')
                        <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
 
            <div class="form-row">
                <div class="form-field">
                    <label class="form-label" for="start_time">Start Date & Time <span style="color:var(--danger)">*</span></label>
                    <input class="form-input @error('start_time') is-invalid @enderror"
                        type="datetime-local" id="start_time" name="start_time"
                        value="{{ old('start_time', \Carbon\Carbon::parse($meeting->start_time)->format('Y-m-d\TH:i')) }}" required>
                    @error('start_time')
                        <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="form-field">
                    <label class="form-label" for="end_time">
                        End Date & Time
                        <span style="font-weight:400;color:var(--ink-3);">(optional)</span>
                    </label>
                    <input class="form-input @error('end_time') is-invalid @enderror"
                        type="datetime-local" id="end_time" name="end_time"
                        value="{{ old('end_time', $meeting->end_time ? \Carbon\Carbon::parse($meeting->end_time)->format('Y-m-d\TH:i') : '') }}">
                    @error('end_time')
                        <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
 
            <div class="form-row">
                <div class="form-field">
                    <label class="form-label" for="location">
                        Location
                        <span style="font-weight:400;color:var(--ink-3);">(optional)</span>
                    </label>
                    <input class="form-input"
                        type="text" id="location" name="location"
                        value="{{ old('location', $meeting->location) }}"
                        placeholder="e.g. Conference Room A">
                </div>
                <div class="form-field">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-input" id="status" name="status">
                        <option value="upcoming"  {{ old('status', $meeting->status) == 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing"   {{ old('status', $meeting->status) == 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status', $meeting->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $meeting->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
 
        </div>
 
        <div class="form-footer">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-lg"></i> Save Changes
            </button>
            <a href="{{ route('meetings.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection