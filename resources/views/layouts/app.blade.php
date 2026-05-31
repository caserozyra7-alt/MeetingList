<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeetSync — @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #f7f7f5;
            --card: #ffffff;
            --ink: #111318;
            --ink-2: #52555e;
            --ink-3: #9396a0;
            --border: #e8e8e4;
            --accent: #3d6b52;
            --accent-hover: #2e5140;
            --accent-light: #edf4f0;
            --danger: #b94040;
            --danger-bg: #fdf3f3;
            --danger-border: #f0c8c8;
            --success-bg: #f0faf4;
            --success-border: #a8d5b8;
            --success-color: #2e5140;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
            --sidebar-w: 240px;
            --surface: #ffffff;
            --surface-2: #f7f7f5;
            --text: #111318;
            --muted: #9396a0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
        }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
            transition: transform 0.28s cubic-bezier(0.22,1,0.36,1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand-icon {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.95rem;
            flex-shrink: 0;
        }

        .sidebar-brand-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.02em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
        }

        .sidebar-section {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--ink-3);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.75rem 0.5rem 0.4rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0.62rem 0.75rem;
            border-radius: 9px;
            font-size: 1.05rem;
            font-weight: 500;
            color: var(--ink-2);
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }

        .sidebar-link i { font-size: 1.05rem; flex-shrink: 0; }

        .sidebar-link:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        .sidebar-link.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0.5rem 0.75rem;
            border-radius: 9px;
            margin-bottom: 0.5rem;
        }

        .sidebar-avatar {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sidebar-avatar img {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .sidebar-user-info { overflow: hidden; }

        .sidebar-user-name {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-email {
            font-size: 0.8rem;
            color: var(--ink-3);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 100%;
            padding: 0.62rem 0.75rem;
            border-radius: 9px;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--danger);
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
            text-align: left;
        }

        .sidebar-logout:hover { background: var(--danger-bg); }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--ink-2);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background 0.15s;
        }

        .topbar-toggle:hover { background: var(--bg); }

        .topbar-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--ink);
        }

        .topbar-actions { display: flex; align-items: center; gap: 8px; }

        .page-content { padding: 1.75rem; flex: 1; }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 99;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .topbar-toggle { display: flex; }
            .overlay.show { display: block; }
            .page-content { padding: 1.25rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="layout">

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <span class="sidebar-brand-name">Meeting Central</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section">Main</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a href="{{ route('meetings.index') }}" class="sidebar-link {{ request()->routeIs('meetings.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Meetings
            </a>
            <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profile
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="avatar">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-left"></i> Sign out
                </button>
            </form>
        </div>
    </aside>

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <div class="page-content">
            @yield('content')
        </div>
    </div>

</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
}
</script>
@stack('scripts')
</body>
</html>