<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan TahuFlow</title>
    <style>
        @page {
            margin: 40px 35px 50px 35px;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        /* ========== HEADER ========== */
        .report-header {
            border-bottom: 3px solid #d97706;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #78350f;
            letter-spacing: -0.5px;
        }

        .company-name span {
            color: #d97706;
        }

        .company-subtitle {
            font-size: 9px;
            color: #78716c;
            margin-top: 2px;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }

        .report-period {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ========== SUMMARY STATS ========== */
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }

        .summary-box {
            display: table-cell;
            width: 33.33%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            background: #fefce8;
        }

        .summary-box:first-child {
            border-radius: 6px 0 0 6px;
        }

        .summary-box:last-child {
            border-radius: 0 6px 6px 0;
        }

        .summary-box.green {
            background: #f0fdf4;
        }

        .summary-box.red {
            background: #fef2f2;
        }

        .summary-label {
            font-size: 8.5px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }

        .summary-value.green { color: #15803d; }
        .summary-value.red { color: #b91c1c; }

        /* ========== DATA TABLE ========== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .data-table thead th {
            background: #78350f;
            color: #ffffff;
            padding: 8px 10px;
            text-align: left;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border: 1px solid #451a03;
        }

        .data-table thead th:first-child {
            border-top-left-radius: 4px;
        }

        .data-table thead th:last-child {
            border-top-right-radius: 4px;
        }

        .data-table tbody td {
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
            font-size: 9.5px;
            color: #1e293b;
        }

        .data-table tbody tr:nth-child(even) td {
            background: #fafaf9;
        }

        .data-table tbody tr:nth-child(odd) td {
            background: #ffffff;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-green {
            color: #15803d;
        }

        .text-red {
            color: #b91c1c;
        }

        .text-muted {
            color: #78716c;
        }

        /* Status badges */
        .status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: bold;
        }

        .status-paid {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }

        .status-partial {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        /* ========== FOOTER ROW ========== */
        .total-row td {
            background: #fef3c7 !important;
            font-weight: bold;
            font-size: 10px;
            color: #78350f;
            padding: 8px 10px;
            border: 1px solid #fde68a;
        }

        /* ========== PAGE FOOTER ========== */
        .page-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
            font-size: 8px;
            color: #94a3b8;
        }

        .footer-right {
            display: table-cell;
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <!-- ========== HEADER ========== -->
    <div class="report-header">
        <div class="header-top">
            <div class="header-left">
                <div class="company-name">Tahu<span>Flow</span></div>
                <div class="company-subtitle">Sistem Manajemen Operasional Pabrik Tahu</div>
            </div>
            <div class="header-right">
                <div class="report-title">Laporan Penjualan</div>
                <div class="report-period">
                    Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
                    s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- ========== SUMMARY ========== -->
    <div class="summary-row">
        <div class="summary-box">
            <div class="summary-label">Total Omzet Penjualan</div>
            <div class="summary-value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box green">
            <div class="summary-label">Pembayaran Diterima</div>
            <div class="summary-value green">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box red">
            <div class="summary-label">Sisa Piutang</div>
            <div class="summary-value red">Rp {{ number_format($totalSisa, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- ========== DATA TABLE ========== -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 130px;">No. Invoice</th>
                <th style="width: 85px;">Tanggal</th>
                <th>Nama Pelanggan</th>
                <th style="width: 110px;" class="text-right">Total Penjualan</th>
                <th style="width: 110px;" class="text-right">Sudah Dibayar</th>
                <th style="width: 100px;" class="text-right">Sisa Piutang</th>
                <th style="width: 75px;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-bold">{{ $sale->invoice_no }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                <td>{{ $sale->customer ? $sale->customer->name : 'Umum (Walk-in)' }}</td>
                <td class="text-right text-bold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                <td class="text-right text-green">Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                <td class="text-right {{ ($sale->total - $sale->paid_amount) > 0 ? 'text-red' : 'text-muted' }}">
                    Rp {{ number_format($sale->total - $sale->paid_amount, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @if($sale->status == 'paid')
                        <span class="status status-paid">Lunas</span>
                    @elseif($sale->status == 'partial')
                        <span class="status status-partial">Sebagian</span>
                    @else
                        <span class="status status-unpaid">Belum Lunas</span>
                    @endif
                </td>
            </tr>
            @endforeach

            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN :</td>
                <td class="text-right">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalSisa, 0, ',', '.') }}</td>
                <td class="text-center">{{ $sales->count() }} trx</td>
            </tr>
        </tbody>
    </table>

    <!-- ========== FOOTER ========== -->
    <div class="page-footer">
        <div class="footer-left">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y — H:i') }} WIB
        </div>
        <div class="footer-right">
            TahuFlow &copy; {{ date('Y') }} — Laporan ini digenerate secara otomatis oleh sistem.
        </div>
    </div>

</body>
</html>
