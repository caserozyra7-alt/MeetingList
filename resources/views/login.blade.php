@extends('layouts.main')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --bg: #f7f7f5;
        --card: #ffffff;
        --ink: #111318;
        --ink-2: #52555e;
        --ink-3: #9396a0;
        --border: #e8e8e4;
        --accent: #3d6b52;
        --accent-hover: #2e5140;
        --danger: #b94040;
        --danger-bg: #fdf3f3;
        --danger-border: #f0c8c8;
        --radius: 12px;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
    }

    .auth-page {
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-height: 100vh;
        background: url('/images/office.jpg') center center / cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        position: relative;
    }

    .auth-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(10, 20, 15, 0.55);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
    }

    .auth-card {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18), 0 1px 3px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 420px;
        padding: 2.75rem 2.5rem;
        border: 1px solid rgba(255,255,255,0.6);
        animation: fadeUp 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .auth-brand {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 2.25rem;
    }

    .auth-brand-icon {
        width: 36px;
        height: 36px;
        background: var(--accent);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
    }

    .auth-brand-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .auth-title {
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.03em;
        margin-bottom: 0.3rem;
    }

    .auth-sub {
        font-size: 0.875rem;
        color: var(--ink-3);
        margin-bottom: 2rem;
    }

    .auth-sub a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .auth-sub a:hover { text-decoration: underline; }

    .auth-alert {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        background: var(--danger-bg);
        border: 1px solid var(--danger-border);
        border-radius: var(--radius);
        padding: 0.7rem 0.9rem;
        font-size: 0.83rem;
        color: var(--danger);
        margin-bottom: 1.25rem;
        line-height: 1.4;
    }

    .auth-alert i { flex-shrink: 0; margin-top: 1px; }

    .auth-field { margin-bottom: 1rem; }

    .auth-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink-2);
        margin-bottom: 0.4rem;
        letter-spacing: 0.01em;
    }

    .auth-field-wrap { position: relative; }

    .auth-field-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--ink-3);
        font-size: 0.95rem;
        pointer-events: none;
    }

    .auth-input {
        width: 100%;
        padding: 0.68rem 2.6rem 0.68rem 2.5rem;
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        color: var(--ink);
        background: var(--card);
        transition: border-color 0.18s, box-shadow 0.18s;
        outline: none;
    }

    .auth-input::placeholder { color: var(--ink-3); }

    .auth-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(61,107,82,0.12);
    }

    .auth-input.is-invalid {
        border-color: var(--danger);
        background: var(--danger-bg);
    }

    .auth-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(185,64,64,0.1);
    }

    .auth-toggle-pw {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--ink-3);
        cursor: pointer;
        font-size: 0.95rem;
        padding: 0;
        transition: color 0.15s;
        line-height: 1;
    }

    .auth-toggle-pw:hover { color: var(--ink); }

    .auth-field-error {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.775rem;
        color: var(--danger);
        margin-top: 0.35rem;
    }

    .auth-row-inline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0.25rem 0 1.5rem;
    }

    .auth-check-label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.83rem;
        color: var(--ink-2);
        cursor: pointer;
        user-select: none;
    }

    .auth-check-label input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: var(--accent);
        cursor: pointer;
    }

    .auth-link-muted {
        font-size: 0.82rem;
        color: var(--ink-3);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.15s;
    }

    .auth-link-muted:hover { color: var(--accent); }

    .auth-btn {
        width: 100%;
        padding: 0.78rem;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        cursor: pointer;
        transition: background 0.18s, transform 0.12s, box-shadow 0.18s;
        box-shadow: 0 1px 2px rgba(61,107,82,0.2), 0 4px 12px rgba(61,107,82,0.18);
    }

    .auth-btn:hover {
        background: var(--accent-hover);
        box-shadow: 0 2px 4px rgba(61,107,82,0.25), 0 6px 16px rgba(61,107,82,0.22);
        transform: translateY(-1px);
    }

    .auth-btn:active { transform: translateY(0); box-shadow: none; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 460px) {
        .auth-card { padding: 2rem 1.5rem; }
    }
</style>

<div class="auth-page">
    <div class="auth-card">

        <div class="auth-brand">
            <div class="auth-brand-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <span class="auth-brand-name">Meeting Central</span>
        </div>

        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>

        @if(session('error'))
        <div class="auth-alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="auth-alert" style="background:#f0faf4; border-color:#a8d5b8; color:#2e5140;">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->has('email') && $errors->first('email') === 'These credentials do not match our records.')
        <div class="auth-alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ $errors->first('email') }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            <div class="auth-field">
                <label class="auth-label" for="email">Email address</label>
                <div class="auth-field-wrap">
                    <i class="bi bi-envelope auth-field-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="auth-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autocomplete="email"
                        required
                    >
                </div>
                @error('email')
                    @if($message !== 'These credentials do not match our records.')
                    <div class="auth-field-error">
                        <i class="bi bi-x-circle-fill"></i> {{ $message }}
                    </div>
                    @endif
                @enderror
            </div>

            <div class="auth-field">
                <label class="auth-label" for="password">Password</label>
                <div class="auth-field-wrap">
                    <i class="bi bi-lock auth-field-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="auth-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="auth-toggle-pw" onclick="authTogglePw('password', this)" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                <div class="auth-field-error">
                    <i class="bi bi-x-circle-fill"></i> {{ $message }}
                </div>
                @enderror
            </div>

            <div class="auth-row-inline"></div>

            <button type="submit" class="auth-btn">Sign in</button>
        </form>

    </div>
</div>

<script>
function authTogglePw(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection