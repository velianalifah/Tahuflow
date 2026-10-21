<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::today()->toDateString());

        $query = Sale::with(['customer', 'items.product'])
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc');

        $sales = $query->paginate(15)->withQueryString();

        $totalOmzet = Sale::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->sum('total');

        $totalPaid = Sale::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->sum('paid_amount');

        $totalTransactions = Sale::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->count();

        return view('reports.sales', compact(
            'sales',
            'startDate',
            'endDate',
            'totalOmzet',
            'totalPaid',
            'totalTransactions'
        ));
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::today()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::today()->toDateString());

        $sales = Sale::with('customer')
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $filename = 'Laporan_Penjualan_TahuFlow_' . Carbon::parse($startDate)->format('Ymd') . '_sd_' . Carbon::parse($endDate)->format('Ymd') . '.pdf';

        $totalOmzet = $sales->sum('total');
        $totalPaid = $sales->sum('paid_amount');
        $totalSisa = $totalOmzet - $totalPaid;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.export_pdf', compact(
            'sales',
            'startDate',
            'endDate',
            'totalOmzet',
            'totalPaid',
            'totalSisa'
        ))->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
