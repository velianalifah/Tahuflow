<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
        }
        .main-title {
            font-size: 16pt;
            font-weight: bold;
            color: #78350f;
            text-align: center;
        }
        .subtitle {
            font-size: 11pt;
            color: #64748b;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        .header-row th {
            background-color: #fef08a;
            color: #78350f;
            font-weight: bold;
            border: 1px solid #d97706;
            padding: 10px 8px;
            font-size: 11pt;
            text-align: center;
        }
        .data-row td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 10.5pt;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .total-row td {
            background-color: #fef9c3;
            font-weight: bold;
            border: 2px solid #d97706;
            padding: 10px 8px;
            font-size: 11pt;
        }
        .num {
            mso-number-format: "\#\,\#\#0";
        }
        .str {
            mso-number-format: "\@";
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="9" class="main-title">LAPORAN PENJUALAN TAHUFLOW</td>
        </tr>
        <tr>
            <td colspan="9" class="subtitle">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
            </td>
        </tr>
        <tr><td colspan="9"></td></tr>
    </table>

    <table border="1">
        <thead>
            <tr class="header-row">
                <th style="width: 50px;">No</th>
                <th style="width: 150px;">No. Invoice</th>
                <th style="width: 110px;">Tanggal</th>
                <th style="width: 220px;">Nama Pelanggan</th>
                <th style="width: 160px;">Total Penjualan (Rp)</th>
                <th style="width: 160px;">Sudah Dibayar (Rp)</th>
                <th style="width: 160px;">Sisa Piutang (Rp)</th>
                <th style="width: 130px;">Status</th>
                <th style="width: 220px;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $idx => $sale)
                <tr class="data-row">
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center str"><strong>{{ $sale->invoice_no }}</strong></td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                    <td class="text-left">{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                    <td class="text-right num">{{ $sale->total }}</td>
                    <td class="text-right num" style="color: #15803d;">{{ $sale->paid_amount }}</td>
                    <td class="text-right num" style="color: {{ ($sale->total - $sale->paid_amount) > 0 ? '#b91c1c' : '#64748b' }};">
                        {{ $sale->total - $sale->paid_amount }}
                    </td>
                    <td class="text-center">
                        @if($sale->status == 'paid')
                            Lunas
                        @elseif($sale->status == 'partial')
                            Sebagian / DP
                        @else
                            Belum Lunas
                        @endif
                    </td>
                    <td class="text-left">{{ $sale->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr class="data-row">
                    <td colspan="9" class="text-center" style="padding: 16px; color: #64748b;">
                        Tidak ada transaksi penjualan dalam periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-right num">{{ $totalOmzet }}</td>
                <td class="text-right num" style="color: #15803d;">{{ $totalPaid }}</td>
                <td class="text-right num" style="color: #b91c1c;">{{ $totalSisa }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
