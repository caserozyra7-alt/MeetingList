@extends('layouts.app')

@section('title', 'New Meeting')

@section('topbar-actions')
    <a href="{{ route('meetings.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer;border:1px solid var(--border);color:var(--ink-2);text-decoration:none;background:transparent;">
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
        overflow: hidden;
    }

    .form-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card-header-icon {
        width: 36px; height: 36px;
        background: var(--accent-light);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .form-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }

    .form-card-subtitle {
        font-size: 0.78rem;
        color: var(--ink-3);
        margin-top: 1px;
    }

    .form-body { padding: 1.5rem; }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem;
    }

    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--ink-3);
    }

    .form-label span { color: var(--danger); margin-left: 2px; }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.85rem;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-family: inherit;
        font-size: 0.875rem;
        color: var(--ink);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(61,107,82,0.1);
        background: var(--card);
    }

    .form-control::placeholder { color: var(--ink-3); }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    select.form-control { cursor: pointer; }

    .form-hint {
        font-size: 0.75rem;
        color: var(--ink-3);
        margin-top: 2px;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: var(--danger);
        margin-top: 2px;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(185,64,64,0.08);
    }

    .form-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 0.6rem 1.25rem;
        background: var(--accent); color: #fff;
        border: none; border-radius: var(--radius);
        font-family: inherit; font-size: 0.875rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background 0.18s;
    }

    .btn-primary:hover { background: var(--accent-hover); }

    .btn-ghost {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 0.6rem 1.1rem;
        background: none; color: var(--ink-2);
        border: 1.5px solid var(--border); border-radius: var(--radius);
        font-family: inherit; font-size: 0.875rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: border-color 0.15s, color 0.15s;
    }

    .btn-ghost:hover { border-color: var(--ink-2); color: var(--ink); }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: 1; }
    }
</style>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-header-icon">
            <i class="bi bi-calendar-plus"></i>
        </div>
        <div>
            <div class="form-card-title">New Meeting</div>
            <div class="form-card-subtitle">Fill in the details below to schedule a meeting</div>
        </div>
    </div>

    <form method="POST" action="{{ route('meetings.store') }}">
        @csrf
        <div class="form-body">
            <div class="form-grid">

                {{-- Title --}}
                <div class="form-group full">
                    <label class="form-label">Title <span>*</span></label>
                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                        placeholder="e.g. Weekly Team Standup" value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Description --}}
                <div class="form-group full">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                        placeholder="What is this meeting about?">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Start Time --}}
                <div class="form-group">
                    <label class="form-label">Start Time <span>*</span></label>
                    <input type="datetime-local" name="start_time" class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                        value="{{ old('start_time') }}" required>
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- End Time --}}
                <div class="form-group">
                    <label class="form-label">End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                        value="{{ old('end_time') }}">
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <span class="form-hint">Must be after start time</span>
                </div>

                {{-- Location --}}
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}"
                        placeholder="e.g. Conference Room A" value="{{ old('location') }}">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="upcoming"  {{ old('status', 'upcoming') === 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing"   {{ old('status') === 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('meetings.index') }}" class="btn-ghost">Cancel</a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-calendar-plus"></i> Create Meeting
            </button>
        </div>
    </form>
</div>
@endsection