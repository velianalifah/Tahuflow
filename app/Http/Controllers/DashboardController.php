<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Production;
use App\Models\RawMaterial;
use App\Models\Sale;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. KPI Stats
        $salesToday = Sale::whereDate('date', $today)->sum('total');
        $productionToday = Production::whereDate('date', $today)->sum('qty_produced');
        $failedProductionToday = Production::whereDate('date', $today)->sum('qty_failed');
        $totalProductStock = Product::sum('stock');
        
        // Critical raw materials
        $criticalMaterials = RawMaterial::whereColumn('stock', '<=', 'min_stock')->get();
        $criticalCount = $criticalMaterials->count();

        // 2. Recent Sales (ordered by date desc, id desc)
        $recentSales = Sale::with('customer')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 3. Recent Productions
        $recentProductions = Production::with('product')
            ->latest('id')
            ->take(5)
            ->get();

        // 4. Products Summary
        $products = Product::where('is_active', true)->take(4)->get();

        // 5. Daily 7-Day Chart Data
        $dailyLabels = [];
        $dailySales = [];
        $dailyProduction = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailyLabels[] = $date->translatedFormat('D, d M');
            $dailySales[] = (float) Sale::whereDate('date', $date)->sum('total');
            $dailyProduction[] = (float) Production::whereDate('date', $date)->sum('qty_produced');
        }

        // 6. Monthly 6-Month Chart Data
        $monthlyLabels = [];
        $monthlySales = [];
        $monthlyProduction = [];

        for ($i = 5; $i >= 0; $i--) {
            $mDate = Carbon::today()->startOfMonth()->subMonths($i);
            $monthlyLabels[] = $mDate->translatedFormat('F Y');
            $monthlySales[] = (float) Sale::whereYear('date', $mDate->year)
                ->whereMonth('date', $mDate->month)
                ->sum('total');
            $monthlyProduction[] = (float) Production::whereYear('date', $mDate->year)
                ->whereMonth('date', $mDate->month)
                ->sum('qty_produced');
        }

        // Summary counts for badges
        $counts = [
            'customers' => Customer::count(),
            'products' => Product::count(),
            'raw_materials' => RawMaterial::count(),
        ];

        return view('dashboard', compact(
            'salesToday',
            'productionToday',
            'failedProductionToday',
            'totalProductStock',
            'criticalMaterials',
            'criticalCount',
            'recentSales',
            'recentProductions',
            'products',
            'dailyLabels',
            'dailySales',
            'dailyProduction',
            'monthlyLabels',
            'monthlySales',
            'monthlyProduction',
            'counts'
        ));
    }
}
