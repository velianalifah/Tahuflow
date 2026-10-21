<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Guest routes (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

// Authenticated routes (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan-penjualan', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/laporan-penjualan/export', [ReportController::class, 'exportSales'])->name('reports.sales.export');
});
