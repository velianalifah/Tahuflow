@extends('layouts.app')

@section('title', 'Dashboard — TahuFlow')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    /* Topbar */
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

    .date-pill {
        font-size: 12.5px;
        color: #64748b;
        padding: 6.5px 12px;
        background: #fafaf9;
        border: 1px solid #e7e5e4;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-action {
        padding: 7px 14px;
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        box-shadow: 0 3px 8px rgba(217, 119, 6, 0.22);
        display: inline-flex;
        align-items: center;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(217, 119, 6, 0.3);
    }

    /* Admin Profile Dropdown */
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

    .fade-in {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* 3 KPI Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 16px 18px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        min-width: 0;
    }

    .kpi-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: transparent;
        transition: background 0.25s ease;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .kpi-card:hover::after {
        background: linear-gradient(90deg, #facc15, #d97706);
    }

    .kpi-title {
        font-size: 12px;
        font-weight: 600;
        color: #78716c;
        margin-bottom: 8px;
    }

    .kpi-value {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.4px;
        line-height: 1.2;
        word-break: break-word;
    }

    .kpi-footer {
        margin-top: 8px;
        font-size: 12px;
        color: #78716c;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .kpi-tag {
        font-size: 10.5px;
        font-weight: 700;
        padding: 1.5px 6px;
        border-radius: 4px;
    }

    .kpi-tag.good {
        background: #dcfce7;
        color: #15803d;
    }

    .kpi-tag.warn {
        background: #fee2e2;
        color: #b91c1c;
    }

    .kpi-tag.neutral {
        background: #f5f5f4;
        color: #57534e;
    }

    /* Full-Width Cards */
    .card {
        background: #ffffff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        margin-bottom: 18px;
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f5f5f4;
    }

    .card-header h3 {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .card-subtitle {
        font-size: 12px;
        color: #78716c;
        margin-top: 2px;
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
        transition: background 0.15s ease;
        white-space: nowrap;
    }

    .data-table td:nth-child(3) {
        white-space: normal;
        min-width: 120px;
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

    @media (max-width: 900px) {
        .kpi-grid { grid-template-columns: 1fr; }
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
            <a href="{{ route('dashboard') }}" class="menu-link active">
                <span>Dashboard</span>
            </a>

            <div class="menu-header">Master Data</div>
            <a href="#" class="menu-link">
                <span>Produk Tahu</span>
                <span class="menu-badge">{{ $counts['products'] }}</span>
            </a>
            <a href="#" class="menu-link">
                <span>Bahan Baku</span>
                <span class="menu-badge {{ $criticalCount > 0 ? 'warning' : '' }}">{{ $counts['raw_materials'] }}</span>
            </a>
            <a href="#" class="menu-link">
                <span>Pemasok (Supplier)</span>
            </a>
            <a href="#" class="menu-link">
                <span>Pelanggan</span>
                <span class="menu-badge">{{ $counts['customers'] }}</span>
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
            <a href="{{ route('reports.sales') }}" class="menu-link">
                <span>Laporan Penjualan</span>
            </a>
        </nav>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <h2>Ringkasan Operasional Pabrik</h2>
                <p>Pantau penjualan, stok, dan hasil produksi secara terpadu.</p>
            </div>
            
            <div class="topbar-right">
                <div class="date-pill">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>

                <a href="#" class="btn-action">
                    + Catat Produksi
                </a>

                <div class="profile-dropdown-wrapper" id="profileDropdown">
                    <button class="profile-btn" id="profileBtn" type="button" aria-expanded="false">
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

        <div class="content-body fade-in">
            <!-- 3 KPI Cards -->
            <div class="kpi-grid">
                <!-- KPI 1 -->
                <div class="kpi-card">
                    <div class="kpi-title">Penjualan Hari Ini</div>
                    <div class="kpi-value">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                    <div class="kpi-footer">
                        <span class="kpi-tag good">Aktif</span>
                        <span>Total transaksi pesanan hari ini</span>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="kpi-card">
                    <div class="kpi-title">Hasil Produksi Hari Ini</div>
                    <div class="kpi-value">{{ number_format($productionToday, 0, ',', '.') }} <span style="font-size: 14px; font-weight: 600; color: #78716c;">Unit</span></div>
                    <div class="kpi-footer">
                        <span class="kpi-tag {{ $failedProductionToday > 0 ? 'warn' : 'good' }}">
                            {{ number_format($failedProductionToday, 0) }} gagal
                        </span>
                        <span>Hasil cetak tahu siap olah</span>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="kpi-card">
                    <div class="kpi-title">Total Stok Tahu Siap Jual</div>
                    <div class="kpi-value">{{ number_format($totalProductStock, 0, ',', '.') }} <span style="font-size: 14px; font-weight: 600; color: #78716c;">Unit</span></div>
                    <div class="kpi-footer">
                        <span class="kpi-tag neutral">{{ $counts['products'] }} varian produk</span>
                        <span>Siap dipasarkan ke pelanggan</span>
                    </div>
                </div>
            </div>

            <!-- Full-Width Chart: Daily Trend Only -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>Tren Penjualan Harian</h3>
                        <span class="card-subtitle">Aktivitas penjualan dan hasil produksi selama 7 hari terakhir</span>
                    </div>
                </div>
                
                <div style="height: 270px; position: relative;">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>

            <!-- Full-Width Recent Sales Table -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3>Penjualan Terbaru</h3>
                        <span class="card-subtitle">Daftar transaksi pesanan pelanggan teranyar</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total Penjualan</th>
                                <th>Sudah Dibayar</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td><strong>{{ $sale->invoice_no }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                                    <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                                    <td><strong>Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></td>
                                    <td style="color: #15803d; font-weight: 600;">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="status-badge {{ $sale->status }}">
                                            {{ $sale->status == 'paid' ? 'Lunas' : ($sale->status == 'partial' ? 'Sebagian / DP' : 'Belum Lunas') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; color: #78716c; padding: 24px;">Belum ada transaksi penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

        // Daily Chart
        const dailyLabels = @json($dailyLabels);
        const dailySales = @json($dailySales);
        const dailyProduction = @json($dailyProduction);

        const ctx = document.getElementById('performanceChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [
                    {
                        label: 'Penjualan (Rp)',
                        data: dailySales,
                        backgroundColor: '#d97706',
                        borderRadius: 6,
                        barThickness: 28,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Produksi (Unit)',
                        data: dailyProduction,
                        type: 'line',
                        borderColor: '#059669',
                        backgroundColor: 'rgba(5, 150, 105, 0.08)',
                        fill: true,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#059669',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        tension: 0.3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 650,
                    easing: 'easeOutQuart'
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: { family: 'Inter', size: 12, weight: 600 },
                            usePointStyle: true,
                            boxWidth: 7,
                            padding: 14
                        }
                    },
                    tooltip: {
                        padding: 10,
                        backgroundColor: '#1c1917',
                        titleFont: { family: 'Inter', size: 12, weight: 700 },
                        bodyFont: { family: 'Inter', size: 12 },
                        cornerRadius: 8,
                        boxPadding: 4
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11, color: '#78716c' } }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: '#f5f5f4' },
                        ticks: {
                            font: { family: 'Inter', size: 11, color: '#78716c' },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value/1000000) + 'jt';
                                if (value >= 1000) return 'Rp ' + (value/1000) + 'rb';
                                return value;
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: {
                            font: { family: 'Inter', size: 11, color: '#78716c' },
                            callback: function(value) { return value + ' unit'; }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush