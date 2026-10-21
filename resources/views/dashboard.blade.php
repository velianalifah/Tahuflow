@extends('layouts.app')

@section('title', 'Dashboard — TahuFlow')

@push('styles')
<style>
    .dashboard-wrapper {
        min-height: 100vh;
        background: #faf8f5;
        color: #1e293b;
    }

    .topbar {
        background: #ffffff;
        border-bottom: 1px solid rgba(245, 158, 11, 0.25);
        padding: 16px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
    }

    .topbar-brand {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.5px;
    }

    .topbar-brand .logo-badge {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #fef08a, #f59e0b);
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }

    .topbar-brand span {
        color: #d97706;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .topbar-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .topbar-user .avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #fef08a, #fbbf24);
        border: 2px solid #ffffff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        color: #78350f;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }

    .topbar-user .user-info {
        display: flex;
        flex-direction: column;
    }

    .topbar-user .user-name {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .topbar-user .user-role {
        font-size: 11px;
        color: #d97706;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        font-weight: 700;
    }

    .btn-logout {
        padding: 9px 20px;
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-logout:hover {
        background: #fecaca;
        color: #b91c1c;
    }

    .dashboard-content {
        padding: 48px 36px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-card {
        background: #ffffff;
        border: 1px solid rgba(245, 158, 11, 0.22);
        border-radius: 24px;
        padding: 48px 40px;
        text-align: center;
        box-shadow: 0 20px 45px rgba(217, 119, 6, 0.08), 0 4px 18px rgba(0, 0, 0, 0.02);
    }

    .welcome-card .emoji {
        font-size: 52px;
        margin-bottom: 20px;
        display: inline-block;
        filter: drop-shadow(0 6px 14px rgba(245, 158, 11, 0.3));
    }

    .welcome-card h2 {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .welcome-card h2 span {
        color: #d97706;
    }

    .welcome-card p {
        color: #64748b;
        font-size: 16px;
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto;
    }

    .theme-preview-badges {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 28px;
    }

    .theme-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
        background: #fffbeb;
        border: 1px solid rgba(245, 158, 11, 0.25);
        color: #92400e;
    }

    .theme-color-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <nav class="topbar">
        <div class="topbar-brand">
            <span class="logo-badge">🏭</span>
            <div>Tahu<span>Flow</span></div>
        </div>
        <div class="topbar-right">
            <div class="topbar-user">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-content">
        <div class="welcome-card">
            <div class="emoji">🎉</div>
            <h2>Selamat Datang, <span>{{ Auth::user()->name }}</span>!</h2>
            <p>Tema visual telah diubah menjadi <strong>Putih & Kuning (Fresh White & Golden Yellow)</strong> yang cerah, bersih, dan modern!</p>
            
            <div class="theme-preview-badges">
                <div class="theme-badge">
                    <span class="theme-color-dot" style="background: #ffffff; border: 1px solid #cbd5e1;"></span>
                    Putih Bersih
                </div>
                <div class="theme-badge">
                    <span class="theme-color-dot" style="background: #f59e0b; box-shadow: 0 0 8px rgba(245,158,11,0.5);"></span>
                    Kuning Tahu Segar
                </div>
            </div>
        </div>
    </div>
</div>
@endsection