@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<style>
    .page-heading {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .page-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        border-radius: var(--radius);
        padding: 0.7rem 0.9rem;
        font-size: 0.83rem;
        margin-bottom: 1.25rem;
        line-height: 1.4;
    }

    .alert-success {
        background: var(--success-bg);
        border: 1px solid var(--success-border);
        color: var(--success-color);
    }

    .alert-danger {
        background: var(--danger-bg);
        border: 1px solid var(--danger-border);
        color: var(--danger);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.25rem;
        align-items: start;
    }

    .section-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--ink);
    }

    .card-subtitle {
        font-size: 0.75rem;
        color: var(--ink-3);
    }

    .card-body { padding: 1.25rem; }

    .avatar-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 1.75rem 1.25rem;
        text-align: center;
    }

    .avatar-lg {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: var(--accent);
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        border: 3px solid var(--accent-light);
        box-shadow: 0 4px 16px rgba(61,107,82,0.2);
        overflow: hidden;
        flex-shrink: 0;
    }

    .avatar-lg img {
        width: 80px; height: 80px;
        border-radius: 50%;
        object-fit: cover;
        display: block;
    }

    .avatar-upload-label {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--ink-2);
        cursor: pointer;
        transition: border-color 0.15s, color 0.15s;
    }

    .avatar-upload-label:hover { border-color: var(--accent); color: var(--accent); }

    .avatar-remove-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: none;
        border: 1.5px solid var(--danger-border);
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--danger);
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s;
    }

    .avatar-remove-btn:hover { background: var(--danger-bg); }

    .profile-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }

    .profile-email {
        font-size: 0.8rem;
        color: var(--ink-3);
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background: var(--accent-light);
        color: var(--accent);
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        width: 100%;
        margin-top: 0.25rem;
    }

    .stat-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0.75rem;
        text-align: center;
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--accent);
        letter-spacing: -0.03em;
    }

    .stat-label {
        font-size: 0.7rem;
        color: var(--ink-3);
        margin-top: 1px;
    }

    .member-since {
        font-size: 0.72rem;
        color: var(--ink-3);
    }

    .form-section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--ink-3);
        margin-bottom: 0.85rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-row.full { grid-template-columns: 1fr; }

    .form-field { display: flex; flex-direction: column; gap: 0; }

    .form-label {
        display: block;
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

    textarea.form-input { resize: vertical; min-height: 80px; }

    .form-error {
        font-size: 0.775rem;
        color: var(--danger);
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-hint {
        font-size: 0.75rem;
        color: var(--ink-3);
        margin-top: 0.3rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.1rem;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.18s, transform 0.12s;
        box-shadow: 0 1px 2px rgba(61,107,82,0.2), 0 4px 12px rgba(61,107,82,0.18);
    }

    .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        padding: 0.6rem 1.1rem;
        background: var(--bg);
        color: var(--ink-2);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s;
        text-decoration: none;
    }

    .btn-cancel:hover { background: var(--border); }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.6rem 1.1rem;
        background: var(--danger);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .btn-danger:hover { opacity: 0.88; }

    .btn-group {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 0.25rem;
    }

    .strength-bar {
        height: 4px;
        border-radius: 2px;
        background: var(--border);
        margin-top: 8px;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        border-radius: 2px;
        width: 0%;
        transition: width 0.3s, background 0.3s;
    }

    .danger-zone { border-color: var(--danger-border) !important; }

    .danger-zone .card-header {
        background: var(--danger-bg);
        border-color: var(--danger-border);
    }

    .danger-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .danger-info-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 3px;
    }

    .danger-info-sub {
        font-size: 0.8rem;
        color: var(--ink-3);
    }

    .btn-danger-ghost {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.5rem 0.9rem;
        background: none;
        border: 1.5px solid var(--danger-border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--danger);
        cursor: pointer;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .btn-danger-ghost:hover { background: var(--danger-bg); }

    .delete-confirm {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background: var(--danger-bg);
        border: 1px solid var(--danger-border);
        border-radius: var(--radius);
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-grid { animation: fadeUp 0.3s ease both; }

    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="page-top">
    <h1 class="page-heading">Profile</h1>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
</div>
@endif

<div class="profile-grid">

    {{-- Left: Avatar + Stats --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        <div class="section-card avatar-card">
            <div class="card-body">

                {{-- Avatar --}}
                <div class="avatar-lg">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Photo">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>

                <div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-email">{{ $user->email }}</div>
                </div>

                <span class="profile-badge">
                    <i class="bi bi-patch-check-fill"></i> Active Member
                </span>

                {{-- Upload Form --}}
                <form method="POST" action="{{ route('profile.avatar') }}"
                    enctype="multipart/form-data" id="avatar-form" style="width:100%;">
                    @csrf
                    <input type="file" name="avatar" id="avatar-input" accept="image/*"
                        style="display:none;" onchange="document.getElementById('avatar-form').submit()">
                    <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">
                        <label for="avatar-input" class="avatar-upload-label">
                            <i class="bi bi-camera"></i> Change Photo
                        </label>
                        @if($user->avatar)
                        <form method="POST" action="{{ route('profile.avatar.remove') }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="avatar-remove-btn"
                                onclick="return confirm('Remove profile photo?')">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </form>
                        @endif
                    </div>
                    @error('avatar')
                        <div style="font-size:0.75rem;color:var(--danger);margin-top:4px;text-align:center;">
                            {{ $message }}
                        </div>
                    @enderror
                </form>

                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-value">{{ $totalMeetings ?? 0 }}</div>
                        <div class="stat-label">Meetings</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value">{{ $upcomingMeetings ?? 0 }}</div>
                        <div class="stat-label">Upcoming</div>
                    </div>
                </div>

                <div class="member-since">
                    <i class="bi bi-calendar3"></i>
                    Member since {{ $user->created_at->format('M Y') }}
                </div>

            </div>
        </div>

    </div>

    {{-- Right: Forms --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Personal Information --}}
        <div class="section-card">
            <div class="card-header">
                <span class="card-title">Personal Information</span>
                <span class="card-subtitle">Update your personal details</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <p class="form-section-label">Basic Details</p>

                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label" for="name">Full Name</label>
                            <input class="form-input @error('name') is-invalid @enderror"
                                type="text" id="name" name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Juan Dela Cruz" required>
                            @error('name')
                                <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="email">Email Address</label>
                            <input class="form-input @error('email') is-invalid @enderror"
                                type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}"
                                placeholder="you@example.com" required>
                            @error('email')
                                <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row full">
                        <div class="form-field">
                            <label class="form-label" for="phone">
                                Phone Number
                                <span style="font-weight:400;color:var(--ink-3);">(optional)</span>
                            </label>
                            <input class="form-input"
                                type="tel" id="phone" name="phone"
                                value="{{ old('phone', $user->phone ?? '') }}"
                                placeholder="+63 912 345 6789">
                        </div>
                    </div>

                    <div class="form-row full">
                        <div class="form-field">
                            <label class="form-label" for="bio">
                                Bio
                                <span style="font-weight:400;color:var(--ink-3);">(optional)</span>
                            </label>
                            <textarea class="form-input" id="bio" name="bio"
                                placeholder="A short introduction about yourself...">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-check-lg"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="section-card">
            <div class="card-header">
                <span class="card-title">Change Password</span>
                <span class="card-subtitle">Keep your account secure</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row full" style="margin-bottom:1rem;">
                        <div class="form-field">
                            <label class="form-label" for="current_password">Current Password</label>
                            <input class="form-input @error('current_password') is-invalid @enderror"
                                type="password" id="current_password" name="current_password"
                                placeholder="Enter current password">
                            @error('current_password')
                                <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label class="form-label" for="password">New Password</label>
                            <input class="form-input @error('password') is-invalid @enderror"
                                type="password" id="password" name="password"
                                placeholder="Min. 8 characters"
                                oninput="checkStrength(this.value)">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <div class="form-hint" id="strength-label">Enter a new password</div>
                            @error('password')
                                <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="password_confirmation">Confirm New Password</label>
                            <input class="form-input"
                                type="password" id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Re-enter new password">
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-lock"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="section-card danger-zone">
            <div class="card-header">
                <span class="card-title" style="color:var(--danger);">
                    <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                </span>
            </div>
            <div class="card-body">
                <div class="danger-row">
                    <div>
                        <div class="danger-info-title">Delete Account</div>
                        <div class="danger-info-sub">Permanently delete your account and all associated data. This cannot be undone.</div>
                    </div>
                    <button type="button" class="btn-danger-ghost"
                        onclick="document.getElementById('delete-confirm').style.display='block'">
                        <i class="bi bi-trash"></i> Delete Account
                    </button>
                </div>

                <div class="delete-confirm" id="delete-confirm">
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <div class="form-field" style="margin-bottom:0.85rem;">
                            <label class="form-label">Enter your password to confirm</label>
                            <input class="form-input" type="password" name="password"
                                placeholder="Your current password"
                                style="border-color:var(--danger-border);">
                            @error('password')
                                <div class="form-error"><i class="bi bi-x-circle-fill"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn-danger">
                                <i class="bi bi-trash"></i> Confirm Delete
                            </button>
                            <button type="button" class="btn-cancel"
                                onclick="document.getElementById('delete-confirm').style.display='none'">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function checkStrength(val) {
    const fill  = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    const levels = [
        { w: '0%',   c: '#e8e8e4', t: 'Enter a new password' },
        { w: '25%',  c: '#b94040', t: 'Weak' },
        { w: '50%',  c: '#d4821a', t: 'Fair' },
        { w: '75%',  c: '#6aaa7a', t: 'Good' },
        { w: '100%', c: '#3d6b52', t: 'Strong' },
    ];

    const lvl = val.length === 0 ? 0 : Math.min(score + 1, 4);
    fill.style.width      = levels[lvl].w;
    fill.style.background = levels[lvl].c;
    label.textContent     = val.length === 0 ? levels[0].t : levels[lvl].t;
    label.style.color     = levels[lvl].c;
}
</script>
@endpush

@endsection