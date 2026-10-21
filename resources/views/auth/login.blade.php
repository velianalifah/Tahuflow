@extends('layouts.app')

@section('title', 'Login — TahuFlow')

@push('styles')
<style>
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 20px;
        background: radial-gradient(ellipse at top, #fffdf5 0%, #fef9ee 45%, #f6f3eb 100%);
        position: relative;
        overflow: hidden;
    }

    /* Soft warm ambient background orbs */
    .login-wrapper::before,
    .login-wrapper::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.45;
        animation: floatOrb 10s ease-in-out infinite;
    }

    .login-wrapper::before {
        width: 480px;
        height: 480px;
        background: #fde68a;
        top: -120px;
        right: -80px;
    }

    .login-wrapper::after {
        width: 420px;
        height: 420px;
        background: #fef08a;
        bottom: -100px;
        left: -100px;
        animation-delay: 5s;
    }

    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(25px, -20px) scale(1.06); }
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border: 1px solid rgba(245, 158, 11, 0.22);
        border-radius: 24px;
        padding: 44px 38px;
        position: relative;
        z-index: 1;
        box-shadow: 0 20px 45px rgba(217, 119, 6, 0.08), 0 4px 18px rgba(0, 0, 0, 0.04);
    }

    .login-logo {
        text-align: center;
        margin-bottom: 6px;
    }

    .login-logo .icon {
        width: 68px;
        height: 68px;
        background: linear-gradient(135deg, #fef08a 0%, #fbbf24 60%, #f59e0b 100%);
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 16px;
        box-shadow: 0 10px 24px rgba(245, 158, 11, 0.28);
        border: 2px solid #ffffff;
    }

    .login-logo h1 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .login-logo h1 span {
        color: #d97706;
    }

    .login-logo p {
        color: #64748b;
        font-size: 14px;
        margin-top: 6px;
        font-weight: 400;
    }

    .login-form {
        margin-top: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        letter-spacing: 0.1px;
    }

    .form-group .input-wrapper {
        position: relative;
    }

    .form-group .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .form-group input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        color: #0f172a;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.25s ease;
        outline: none;
    }

    .form-group input::placeholder {
        color: #94a3b8;
    }

    .form-group input:focus {
        background: #ffffff;
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.16);
    }

    .form-group input:focus ~ .input-icon {
        color: #d97706;
    }

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 9px;
        cursor: pointer;
        user-select: none;
    }

    .remember-me input[type="checkbox"] {
        appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .remember-me input[type="checkbox"]:checked {
        background: #f59e0b;
        border-color: #f59e0b;
    }

    .remember-me input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
    }

    .remember-me span {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 60%, #d97706 100%);
        border: none;
        border-radius: 14px;
        color: #451a03;
        font-size: 15px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        letter-spacing: 0.2px;
        box-shadow: 0 6px 18px rgba(245, 158, 11, 0.32);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(245, 158, 11, 0.42);
        background: linear-gradient(135deg, #fcd34d 0%, #fbbf24 60%, #d97706 100%);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-footer {
        text-align: center;
        margin-top: 26px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .login-footer p {
        font-size: 13px;
        color: #94a3b8;
    }

    /* Error alert */
    .login-alert {
        padding: 12px 16px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .login-alert .alert-icon {
        font-size: 17px;
        flex-shrink: 0;
    }

    .login-alert p {
        font-size: 13px;
        color: #dc2626;
        font-weight: 500;
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 34px 22px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="icon">🏭</div>
            <h1>Tahu<span>Flow</span></h1>
            <p>Sistem Manajemen Pabrik Tahu</p>
        </div>

        @if ($errors->any())
            <div class="login-alert">
                <span class="alert-icon">⚠️</span>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@tahuflow.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    <span class="input-icon">📧</span>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                    <span class="input-icon">🔒</span>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn-login" id="btn-login">
                Masuk
            </button>
        </form>

        <div class="login-footer">
            <p>© {{ date('Y') }} TahuFlow — All rights reserved</p>
        </div>
    </div>
</div>
@endsection