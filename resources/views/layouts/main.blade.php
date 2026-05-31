<!DOCTYPE html>
<html>
<head>
    <title>Meeting Central</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --toast-success-bg: #0f2e1e;
            --toast-success-border: #22c55e;
            --toast-success-icon: #22c55e;
            --toast-error-bg: #2e0f0f;
            --toast-error-border: #ef4444;
            --toast-error-icon: #ef4444;
            --toast-text: #f1f5f9;
            --toast-subtext: #94a3b8;
        }

        body {
            font-family: 'DM Sans', sans-serif;
        }

        /* ── Toast Container ── */
        .toast-container-custom {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            pointer-events: none;
        }

        /* ── Base Toast ── */
        .meeting-toast {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            min-width: 320px;
            max-width: 400px;
            padding: 1rem 1.1rem;
            border-radius: 12px;
            border-left: 4px solid transparent;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35), 0 2px 8px rgba(0,0,0,0.2);
            pointer-events: all;
            backdrop-filter: blur(8px);
            animation: toastSlideIn 0.38s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            position: relative;
            overflow: hidden;
        }

        .meeting-toast::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 12px;
            opacity: 0.06;
        }

        /* ── Success Toast ── */
        .meeting-toast.toast-success {
            background: var(--toast-success-bg);
            border-left-color: var(--toast-success-border);
        }
        .meeting-toast.toast-success::before {
            background: var(--toast-success-border);
        }
        .meeting-toast.toast-success .toast-icon {
            color: var(--toast-success-icon);
        }
        .meeting-toast.toast-success .toast-progress {
            background: var(--toast-success-border);
        }

        /* ── Error Toast ── */
        .meeting-toast.toast-error {
            background: var(--toast-error-bg);
            border-left-color: var(--toast-error-border);
        }
        .meeting-toast.toast-error::before {
            background: var(--toast-error-border);
        }
        .meeting-toast.toast-error .toast-icon {
            color: var(--toast-error-icon);
        }
        .meeting-toast.toast-error .toast-progress {
            background: var(--toast-error-border);
        }

        /* ── Icon ── */
        .toast-icon {
            font-size: 1.3rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ── Body ── */
        .toast-body-custom {
            flex: 1;
        }
        .toast-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--toast-text);
            margin: 0 0 0.15rem;
            letter-spacing: 0.01em;
        }
        .toast-message {
            font-size: 0.8rem;
            color: var(--toast-subtext);
            margin: 0;
            line-height: 1.45;
        }

        /* ── Close ── */
        .toast-close {
            background: none;
            border: none;
            color: var(--toast-subtext);
            font-size: 1rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            opacity: 0.6;
            transition: opacity 0.2s;
        }
        .toast-close:hover { opacity: 1; }

        /* ── Progress bar ── */
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            border-radius: 0 0 12px 12px;
            animation: toastProgress 4s linear forwards;
        }

        /* ── Animations ── */
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(60px) scale(0.95); }
            to   { opacity: 1; transform: translateX(0)   scale(1); }
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .meeting-toast.toast-hiding {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0) scale(1); max-height: 100px; }
            to   { opacity: 0; transform: translateX(60px) scale(0.95); max-height: 0; padding: 0; margin: 0; }
        }
    </style>
</head>
<body>


{{-- ═══ Toast Container ═══ --}}
<div class="toast-container-custom" id="toastContainer">

    {{-- Success Toast (shown when session has 'success') --}}
    @if(session('success'))
    <div class="meeting-toast toast-success" role="alert" aria-live="polite">
        <span class="toast-icon"><i class="bi bi-check-circle-fill"></i></span>
        <div class="toast-body-custom">
            <p class="toast-title">Success</p>
            <p class="toast-message">{{ session('success') }}</p>
        </div>
        <button class="toast-close" onclick="dismissToast(this)" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="toast-progress"></div>
    </div>
    @endif

    {{-- Error Toast (shown when session has 'error') --}}
    @if(session('error'))
    <div class="meeting-toast toast-error" role="alert" aria-live="assertive">
        <span class="toast-icon"><i class="bi bi-exclamation-circle-fill"></i></span>
        <div class="toast-body-custom">
            <p class="toast-title">Error</p>
            <p class="toast-message">{{ session('error') }}</p>
        </div>
        <button class="toast-close" onclick="dismissToast(this)" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="toast-progress"></div>
    </div>
    @endif

</div>
{{-- ═══ End Toast Container ═══ --}}

<div class="container mt-4">
    @yield('content')
</div>

</body>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Auto-dismiss toasts after 4 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = document.querySelectorAll('.meeting-toast');
        toasts.forEach(function (toast) {
            setTimeout(function () {
                dismissToast(toast.querySelector('.toast-close'));
            }, 4000);
        });
    });

    function dismissToast(btn) {
        const toast = btn.closest('.meeting-toast');
        toast.classList.add('toast-hiding');
        setTimeout(function () {
            toast.remove();
        }, 300);
    }
</script>

</html>
