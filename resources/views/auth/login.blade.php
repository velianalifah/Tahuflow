@extends('layouts.app')

@section('title', 'Login — TahuFlow')

@push('styles')
<style>
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        background: #fbf8f1;
        position: relative;
        overflow: hidden;
    }

    /* Ambient background gradient pattern */
    .login-page::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(253, 224, 71, 0.35) 0%, rgba(245, 158, 11, 0.1) 60%, transparent 80%);
        top: -150px;
        left: -100px;
        filter: blur(50px);
        pointer-events: none;
    }

    .login-page::after {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.25) 0%, rgba(217, 119, 6, 0.08) 60%, transparent 80%);
        bottom: -150px;
        right: -100px;
        filter: blur(50px);
        pointer-events: none;
    }

    .login-container {
        width: 100%;
        max-width: 960px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(120, 53, 15, 0.1), 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(245, 158, 11, 0.2);
        display: flex;
        overflow: hidden;
        position: relative;
        z-index: 10;
    }

    /* ================= LEFT BRAND SHOWCASE ================= */
    .brand-side {
        flex: 1.05;
        background: linear-gradient(145deg, #fef08a 0%, #fde047 30%, #f59e0b 80%, #d97706 100%);
        padding: 44px 38px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        color: #451a03;
    }

    .brand-side::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 85% 15%, rgba(255, 255, 255, 0.45) 0%, transparent 60%);
        pointer-events: none;
    }

    .brand-header {
        position: relative;
        z-index: 2;
    }

    .brand-logo-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(8px);
        padding: 8px 16px 8px 10px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.95);
        box-shadow: 0 4px 12px rgba(180, 83, 9, 0.12);
        margin-bottom: 22px;
    }

    .brand-logo-badge h1 {
        font-size: 20px;
        font-weight: 800;
        color: #78350f;
        letter-spacing: -0.3px;
        margin: 0;
    }

    .brand-logo-badge h1 span {
        color: #d97706;
    }

    .brand-headline {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.35;
        color: #593005;
        margin-bottom: 10px;
        letter-spacing: -0.3px;
    }

    .brand-desc {
        font-size: 13px;
        line-height: 1.6;
        color: #713f12;
        margin-bottom: 24px;
    }

    .features-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 24px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.65);
        padding: 9px 13px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        color: #451a03;
        border: 1px solid rgba(255, 255, 255, 0.75);
    }

    .feature-bullet {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #b45309;
        flex-shrink: 0;
    }

    .brand-footer {
        position: relative;
        z-index: 2;
        font-size: 11.5px;
        color: #78350f;
        opacity: 0.9;
    }

    /* ================= RIGHT FORM ================= */
    .form-side {
        flex: 1.15;
        padding: 44px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #ffffff;
    }

    .form-greeting {
        margin-bottom: 22px;
    }

    .form-greeting h2 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.4px;
    }

    .form-greeting p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .login-alert {
        padding: 10px 14px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .login-alert p {
        font-size: 12.5px;
        color: #dc2626;
        font-weight: 500;
        margin: 0;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 10.5px 13px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #0f172a;
        font-size: 13px;
        font-family: inherit;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus {
        background: #ffffff;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.18);
    }

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        user-select: none;
    }

    .remember-me input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: #d97706;
        cursor: pointer;
    }

    .remember-me span {
        font-size: 12.5px;
        color: #64748b;
    }

    .btn-login {
        width: 100%;
        padding: 11.5px;
        background: #d97706;
        border: none;
        border-radius: 8px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 3px 10px rgba(217, 119, 6, 0.24);
    }

    .btn-login:hover {
        background: #b45309;
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(217, 119, 6, 0.32);
    }


    .login-footer-text {
        text-align: center;
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 20px;
    }

    @media (max-width: 860px) {
        .login-container {
            flex-direction: column;
            max-width: 440px;
        }
        .brand-side {
            padding: 30px 24px;
        }
        .form-side {
            padding: 32px 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-container">
        <!-- ================= BRAND SHOWCASE ================= -->
        <div class="brand-side">
            <div class="brand-header">
                <div class="brand-logo-badge">
                    <svg width="28" height="28" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4L34 12L20 20L6 12L20 4Z" fill="#FFF9C4" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M6 12L20 20V34L6 26V12Z" fill="#F59E0B" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M20 20L34 12V26L20 34V20Z" fill="#D97706" stroke="#B45309" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M4 17C12 11 26 25 36 19" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round"/>
                        <path d="M9 25C15 20 25 30 31 26" stroke="#FEF08A" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="20" cy="20" r="2.5" fill="#FFFFFF"/>
                    </svg>
                    <h1>Tahu<span>Flow</span></h1>
                </div>

                <div class="brand-headline">
                    Sistem Manajemen Terpadu Operasional Pabrik Tahu
                </div>

                <div class="brand-desc">
                    Kelola pencatatan produksi harian, stok bahan baku, transaksi penjualan pelanggan, dan laporan keuangan dalam satu dasbor terintegrasi.
                </div>

                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-bullet"></div>
                        <span>Pemantauan Hasil Produksi & Stok Siap Jual</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-bullet"></div>
                        <span>Pencatatan Penjualan & Piutang Real-time</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-bullet"></div>
                        <span>Ekspor Laporan Rinci ke Dokumen Resmi PDF</span>
                    </div>
                </div>
            </div>

            <div class="brand-footer">
                TahuFlow &copy; {{ date('Y') }} — Solusi digital operasional pabrik tahu.
            </div>
        </div>

        <!-- ================= FORM SIDE ================= -->
        <div class="form-side">
            <div class="form-greeting">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk dengan akun Anda untuk mengakses sistem.</p>
            </div>

            @if ($errors->any())
                <div class="login-alert">
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi (Password)</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" checked>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-login" id="btn-login">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="login-footer-text">
                &copy; {{ date('Y') }} TahuFlow. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection