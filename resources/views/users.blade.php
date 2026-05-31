@extends('layouts.app')
@section('title', 'Users')

@section('content')
<style>
    .page-heading {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -0.02em;
        margin-bottom: 1.5rem;
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
    .user-cell { display: flex; align-items: center; gap: 9px; }
    .user-cell-avatar {
        width: 32px; height: 32px;
        background: var(--accent);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }
    .user-cell-avatar img {
        width: 32px; height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    .user-cell-name { font-weight: 500; color: var(--ink); }
    .btn-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        text-decoration: none;
        transition: opacity 0.15s;
    }
    .btn-danger-sm { background: var(--danger); color: #fff; }
    .btn-danger-sm:hover { opacity: 0.85; }
    .alert {
        display: flex;
        align-items: center;
        gap: 9px;
        border-radius: var(--radius);
        padding: 0.7rem 0.9rem;
        font-size: 0.83rem;
        margin-bottom: 1.25rem;
    }
    .alert-success { background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-color); }
    .alert-danger { background: var(--danger-bg); border: 1px solid var(--danger-border); color: var(--danger); }
</style>

@if(session('success'))
<div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
@endif

<h1 class="page-heading">Users</h1>

<div class="section-card">
    <div class="section-header">
        <span class="section-title">All Users ({{ $users->total() }})</span>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="user-cell-avatar">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <span class="user-cell-name">{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                        onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;color:var(--ink-3);padding:2rem;">No users yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div style="padding:1rem 1.5rem;border-top:1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection