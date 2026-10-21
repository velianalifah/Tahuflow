@extends('layouts.app')

@section('title', 'Laporan Penjualan — TahuFlow')

@push('styles')
<style>
    :root {
        --sidebar-width: 240px;
        --color-primary: #f59e0b;
        --color-primary-dark: #d97706;
        --color-bg: #fafaf9;
        --color-card: #ffffff;
        --color-border: #e7e5e4;
        --color-text-main: #1c1917;
        --color-text-muted: #78716c;
    }

    html, body {
        max-width: 100vw;
        overflow-x: hidden;
        overflow-y: auto;
    }

    body {
        background-color: var(--color-bg);
        color: var(--color-text-main);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .app-layout {
        display: flex;
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* ================= SIDEBAR (Compact & Seamless Yellow) ================= */
    .sidebar {
        width: var(--sidebar-width);
        min-width: var(--sidebar-width);
        max-width: var(--sidebar-width);
        background: linear-gradient(180deg, #fef08a 0%, #fde047 45%, #facc15 100%);
        border-right: 1px solid #eab308;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 50;
        box-shadow: 4px 0 20px rgba(234, 179, 8, 0.12);
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-brand {
        padding: 18px 18px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-logo-wrap {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        filter: drop-shadow(0 2px 5px rgba(161, 98, 7, 0.25));
    }

    .sidebar-brand h1 {
        font-size: 18px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: #451a03;
    }

    .sidebar-brand h1 span {
        color: #b45309;
        font-weight: 900;
    }

    .sidebar-menu {
        flex: 1;
        overflow-y: auto;
        padding: 8px 10px 18px;
        scrollbar-width: thin;
        scrollbar-color: rgba(180, 83, 9, 0.2) transparent;
    }

    .sidebar-menu::-webkit-scrollbar {
        width: 3px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(180, 83, 9, 0.2);
        border-radius: 3px;
    }

    .menu-header {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #78350f;
        opacity: 0.65;
        padding: 0 12px;
        margin-top: 18px;
        margin-bottom: 5px;
    }

    .menu-header:first-child {
        margin-top: 6px;
    }

    .menu-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 12px;
        border-radius: 6px;
        color: #292524;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: background 0.15s ease, color 0.15s ease;
        margin-bottom: 2px;
    }

    .menu-link:hover {
        background: rgba(255, 255, 255, 0.4);
        color: #000000;
    }

    .menu-link.active {
        background: #ffffff;
        color: #1c1917;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    .menu-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 1px 7px;
        border-radius: 9999px;
        background: rgba(0, 0, 0, 0.07);
        color: #44403c;
    }

    .menu-badge.warning {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ================= MAIN CONTENT ================= */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        width: calc(100vw - var(--sidebar-width));
        max-width: calc(100vw - var(--sidebar-width));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .topbar {
        background: #ffffff;
        border-bottom: 1px solid var(--color-border);
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 40;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        flex-wrap: wrap;
        gap: 8px;
    }

    .topbar-left h2 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    .topbar-left p {
        font-size: 12.5px;
        color: var(--color-text-muted);
        margin-top: 1px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-export {
        padding: 7.5px 15px;
        background: #dc2626;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.22);
    }

    .btn-export:hover {
        background: #b91c1c;
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(220, 38, 38, 0.3);
    }

    /* Profile Dropdown */
    .profile-dropdown-wrapper {
        position: relative;
    }

    .profile-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 10px 4px 5px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .profile-btn:hover {
        background: #fefce8;
        border-color: #fde68a;
    }

    .profile-avatar {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #fde047 0%, #f59e0b 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        color: #593005;
    }

    .profile-info {
        text-align: left;
    }

    .profile-name {
        font-size: 12.5px;
        font-weight: 600;
        color: #0f172a;
    }

    .profile-chevron {
        font-size: 9px;
        color: #94a3b8;
    }

    .profile-dropdown-menu {
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 220px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        padding: 6px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-6px) scale(0.96);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 100;
    }

    .profile-dropdown-wrapper.active .profile-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-user-header {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 4px;
    }

    .dropdown-user-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    .dropdown-user-email {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 1px;
    }

    .dropdown-user-role {
        display: inline-block;
        margin-top: 5px;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 4px;
        background: #fef3c7;
        color: #92400e;
        text-transform: uppercase;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 8px 10px;
        font-size: 12.5px;
        font-weight: 500;
        color: #334155;
        border-radius: 6px;
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-align: left;
    }

    .dropdown-item.logout {
        color: #dc2626;
        margin-top: 2px;
        padding-top: 8px;
    }

    .dropdown-item.logout:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    /* Content Body */
    .content-body {
        padding: 18px 20px;
        flex: 1;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .form-group-inline {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group-inline label {
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .form-input {
        padding: 6.5px 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 12.5px;
        font-family: inherit;
        color: #0f172a;
        outline: none;
    }

    .form-input:focus {
        border-color: #d97706;
    }

    .btn-filter {
        padding: 6.5px 14px;
        background: #f59e0b;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-filter:hover {
        background: #d97706;
    }

    /* Stats Summary Grid */
    .report-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 16px;
    }

    .report-stat-card {
        background: #ffffff;
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 14px 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        min-width: 0;
    }

    .report-stat-title {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
    }

    .report-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
        word-break: break-word;
    }

    /* Data Table Card & Responsive Wrapper */
    .card {
        background: #ffffff;
        border: 1px solid var(--color-border);
        border-radius: 10px;
        padding: 14px 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 12.5px;
        table-layout: auto;
    }

    .data-table th {
        text-align: left;
        padding: 8px 10px;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #78716c;
        background: #fafaf9;
        border-bottom: 1px solid #e7e5e4;
        white-space: nowrap;
    }

    .data-table th:first-child { border-top-left-radius: 6px; }
    .data-table th:last-child { border-top-right-radius: 6px; }

    .data-table td {
        padding: 9px 10px;
        border-bottom: 1px solid #f5f5f4;
        color: #292524;
        white-space: nowrap;
    }

    .data-table td:nth-child(3) {
        white-space: normal;
        min-width: 140px;
        max-width: 220px;
    }

    .data-table tbody tr:hover td {
        background: #fefce8;
    }

    .status-badge {
        display: inline-block;
        padding: 2.5px 8px;
        border-radius: 5px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-badge.paid {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .status-badge.partial {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-badge.unpaid {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }

    .pagination-wrap {
        margin-top: 16px;
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 1200px) {
        .report-stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 900px) {
        .report-stats-grid {
            grid-template-columns: 1fr;
        }
        :root {
            --sidebar-width: 180px;
        }
    }
</style>
@endpush

@section('content')
<div class="app-layout">
    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo-wrap">
                <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4L34 12L20 20L6 12L20 4Z" fill="#FFF9C4" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M6 12L20 20V34L6 26V12Z" fill="#F59E0B" stroke="#D97706" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M20 20L34 12V26L20 34V20Z" fill="#D97706" stroke="#B45309" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M4 17C12 11 26 25 36 19" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round"/>
                    <path d="M9 25C15 20 25 30 31 26" stroke="#FEF08A" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="20" cy="20" r="2.5" fill="#FFFFFF"/>
                </svg>
            </div>
            <h1>Tahu<span>Flow</span></h1>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-header">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="menu-link">
                <span>Dashboard</span>
            </a>

            <div class="menu-header">Master Data</div>
            <a href="#" class="menu-link">
                <span>Produk Tahu</span>
            </a>
            <a href="#" class="menu-link">
                <span>Bahan Baku</span>
            </a>
            <a href="#" class="menu-link">
                <span>Pemasok (Supplier)</span>
            </a>
            <a href="#" class="menu-link">
                <span>Pelanggan</span>
            </a>

            <div class="menu-header">Operasional Pabrik</div>
            <a href="#" class="menu-link">
                <span>Produksi Tahu</span>
            </a>
            <a href="#" class="menu-link">
                <span>Pembelian Bahan</span>
            </a>
            <a href="#" class="menu-link">
                <span>Penjualan</span>
            </a>

            <div class="menu-header">Keuangan & Stok</div>
            <a href="#" class="menu-link">
                <span>Riwayat Pembayaran</span>
            </a>
            <a href="#" class="menu-link">
                <span>Mutasi Stok</span>
            </a>

            <div class="menu-header">Laporan & Analisis</div>
            <a href="{{ route('reports.sales') }}" class="menu-link active">
                <span>Laporan Penjualan</span>
            </a>
        </nav>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <h2>Laporan Rinci Penjualan</h2>
                <p>Analisis detail transaksi pesanan pelanggan dan ekspor laporan ke format PDF.</p>
            </div>
            
            <div class="topbar-right">
                <a href="{{ route('reports.sales.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn-export">
                    <span>Export ke PDF (.pdf)</span>
                </a>

                <div class="profile-dropdown-wrapper" id="profileDropdown">
                    <button class="profile-btn" id="profileBtn" type="button">
                        <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <div class="profile-info">
                            <div class="profile-name">{{ Auth::user()->name }}</div>
                        </div>
                        <span class="profile-chevron">▼</span>
                    </button>

                    <div class="profile-dropdown-menu">
                        <div class="dropdown-user-header">
                            <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                            <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                            <span class="dropdown-user-role">{{ Auth::user()->role }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">Keluar (Logout)</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-body">
            <!-- Filter Bar -->
            <div class="filter-card">
                <form class="filter-form" method="GET" action="{{ route('reports.sales') }}">
                    <div class="form-group-inline">
                        <label for="start_date">Dari Tanggal:</label>
                        <input type="date" id="start_date" name="start_date" class="form-input" value="{{ $startDate }}">
                    </div>

                    <div class="form-group-inline">
                        <label for="end_date">Sampai Tanggal:</label>
                        <input type="date" id="end_date" name="end_date" class="form-input" value="{{ $endDate }}">
                    </div>

                    <button type="submit" class="btn-filter">Terapkan Filter</button>
                </form>

                <div style="font-size: 12.5px; color: #64748b;">
                    Total <strong>{{ $totalTransactions }}</strong> transaksi ditemukan
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="report-stats-grid">
                <div class="report-stat-card">
                    <div class="report-stat-title">Total Omzet Penjualan</div>
                    <div class="report-stat-value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                </div>

                <div class="report-stat-card">
                    <div class="report-stat-title">Pembayaran Diterima</div>
                    <div class="report-stat-value" style="color: #15803d;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
                </div>

                <div class="report-stat-card">
                    <div class="report-stat-title">Sisa Piutang / Belum Lunas</div>
                    <div class="report-stat-value" style="color: #b91c1c;">Rp {{ number_format($totalOmzet - $totalPaid, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Detailed Table with Clean Table Responsive Wrapper -->
            <div class="card">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total (Rp)</th>
                                <th>Dibayar (Rp)</th>
                                <th>Sisa (Rp)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td><strong>{{ $sale->invoice_no }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                                    <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                                    <td><strong>Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></td>
                                    <td style="color: #15803d; font-weight: 600;">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                                    <td style="color: {{ ($sale->total - $sale->paid_amount) > 0 ? '#b91c1c' : '#78716c' }};">
                                        Rp {{ number_format($sale->total - $sale->paid_amount, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $sale->status }}">
                                            {{ $sale->status == 'paid' ? 'Lunas' : ($sale->status == 'partial' ? 'Sebagian' : 'Belum Lunas') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #78716c; padding: 24px;">Tidak ada transaksi dalam rentang tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const profileDropdown = document.getElementById('profileDropdown');
        const profileBtn = document.getElementById('profileBtn');

        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (e) {
            if (!profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });
    });
</script>
@endpush
