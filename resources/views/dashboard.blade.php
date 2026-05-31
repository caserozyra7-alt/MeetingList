@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<style>
    .page-heading {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-bottom: 1.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .stat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--shadow);
    }

    .stat-icon {
        width: 44px; height: 44px;
        background: var(--accent-light);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--ink-3);
        margin-top: 3px;
    }

    .section-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .section-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--ink);
    }

    .section-link {
        font-size: 0.8rem;
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
    }

    .section-link:hover { text-decoration: underline; }

    .user-table { width: 100%; border-collapse: collapse; }

    .user-table th {
        padding: 0.7rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--ink-3);
        letter-spacing: 0.04em;
        text-transform: uppercase;
        background: var(--bg);
        border-bottom: 1px solid var(--border);
    }

    .user-table td {
        padding: 0.85rem 1.5rem;
        font-size: 0.875rem;
        color: var(--ink-2);
        border-bottom: 1px solid var(--border);
    }

    .user-table tr:last-child td { border-bottom: none; }

    .user-table tr:hover td { background: var(--bg); }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .user-cell-avatar {
        width: 28px; height: 28px;
        background: var(--accent);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-cell-name {
        font-weight: 500;
        color: var(--ink);
    }

    @media (max-width: 600px) {
        .user-table thead { display: none; }
        .user-table tr { display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
        .user-table td { display: block; padding: 0.15rem 0; border: none; font-size: 0.82rem; }
    }
</style>

<h1 class="page-heading">Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <span class="section-title">Recent Users</span>
        <a href="{{ route('users.index') }}" class="section-link">View all</a>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentUsers as $user)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="user-cell-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        <span class="user-cell-name">{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; color:var(--ink-3); padding: 2rem;">No users yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection