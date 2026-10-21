<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionMaterial;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\RawMaterial;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) {
            return;
        }

        // 1. Raw Materials
        $kedelai = RawMaterial::updateOrCreate(['name' => 'Kedelai Impor Grade A'], [
            'unit' => 'kg',
            'stock' => 1250.00,
            'min_stock' => 300.00,
        ]);

        $kunyit = RawMaterial::updateOrCreate(['name' => 'Kunyit Biang Kuning'], [
            'unit' => 'kg',
            'stock' => 18.50, // di bawah min_stock untuk trigger alert
            'min_stock' => 25.00,
        ]);

        $garam = RawMaterial::updateOrCreate(['name' => 'Garam Kristal Murni'], [
            'unit' => 'kg',
            'stock' => 140.00,
            'min_stock' => 50.00,
        ]);

        $cuka = RawMaterial::updateOrCreate(['name' => 'Bibit Biang Asam Tahu'], [
            'unit' => 'liter',
            'stock' => 60.00,
            'min_stock' => 20.00,
        ]);

        // 2. Products
        $tahuKuning = Product::updateOrCreate(['code' => 'TH-KNG-01'], [
            'name' => 'Tahu Kuning Super (10 pcs/pack)',
            'unit' => 'pack',
            'price' => 15000.00,
            'stock' => 450.00,
            'is_active' => true,
        ]);

        $tahuPutih = Product::updateOrCreate(['code' => 'TH-PTH-02'], [
            'name' => 'Tahu Putih Sutra Cibuntu',
            'unit' => 'papan',
            'price' => 38000.00,
            'stock' => 120.00,
            'is_active' => true,
        ]);

        $tahuSumedang = Product::updateOrCreate(['code' => 'TH-SMD-03'], [
            'name' => 'Tahu Sumedang Crispy (Keranjang)',
            'unit' => 'keranjang',
            'price' => 55000.00,
            'stock' => 85.00,
            'is_active' => true,
        ]);

        // 3. Suppliers
        $sup1 = Supplier::updateOrCreate(['name' => 'UD Kedelai Makmur Abadi'], [
            'phone' => '081234567890',
            'address' => 'Jl. Pergudangan Argo No. 12, Cirebon',
        ]);

        $sup2 = Supplier::updateOrCreate(['name' => 'CV Sumber Rempah Alami'], [
            'phone' => '082198765432',
            'address' => 'Kawasan Pasar Induk Blok C-4',
        ]);

        // 4. Customers
        $cust1 = Customer::updateOrCreate(['name' => 'Toko Sembako Berkah Jaya'], [
            'phone' => '081377889900',
            'address' => 'Pasar Baru Lapak No. 15',
        ]);

        $cust2 = Customer::updateOrCreate(['name' => 'Resto Sari Rasa Sunda'], [
            'phone' => '085611223344',
            'address' => 'Jl. Veteran No. 88',
        ]);

        $cust3 = Customer::updateOrCreate(['name' => 'Warung Gorengan Bu Siti'], [
            'phone' => '087855667788',
            'address' => 'Jl. Diponegoro Gang 3',
        ]);

        // 5. Productions (Hari ini & kemarin)
        $prod1 = Production::updateOrCreate(['code' => 'PRD-'.date('Ymd').'-001'], [
            'date' => Carbon::today(),
            'product_id' => $tahuKuning->id,
            'user_id' => $admin->id,
            'qty_produced' => 250.00,
            'qty_failed' => 4.00,
            'notes' => 'Batch pagi kualitas sangat baik, warna kuning cerah merata.',
        ]);

        ProductionMaterial::updateOrCreate([
            'production_id' => $prod1->id,
            'raw_material_id' => $kedelai->id,
        ], [
            'qty_used' => 120.00,
        ]);

        $prod2 = Production::updateOrCreate(['code' => 'PRD-'.date('Ymd').'-002'], [
            'date' => Carbon::today(),
            'product_id' => $tahuPutih->id,
            'user_id' => $admin->id,
            'qty_produced' => 80.00,
            'qty_failed' => 2.00,
            'notes' => 'Tekstur lembut dan kenyal pas.',
        ]);

        // 6. Sales
        $sale1 = Sale::updateOrCreate(['invoice_no' => 'INV-'.date('Ymd').'-001'], [
            'date' => Carbon::today(),
            'customer_id' => $cust1->id,
            'user_id' => $admin->id,
            'total' => 1500000.00,
            'paid_amount' => 1500000.00,
            'status' => 'paid',
            'notes' => 'Pembayaran via transfer BCA lunas.',
        ]);

        SaleItem::updateOrCreate([
            'sale_id' => $sale1->id,
            'product_id' => $tahuKuning->id,
        ], [
            'qty' => 100.00,
            'price' => 15000.00,
            'subtotal' => 1500000.00,
        ]);

        Payment::updateOrCreate([
            'sale_id' => $sale1->id,
            'date' => Carbon::today(),
        ], [
            'amount' => 1500000.00,
            'method' => 'transfer',
            'notes' => 'Lunas saat pengiriman',
        ]);

        $sale2 = Sale::updateOrCreate(['invoice_no' => 'INV-'.date('Ymd').'-002'], [
            'date' => Carbon::today(),
            'customer_id' => $cust2->id,
            'user_id' => $admin->id,
            'total' => 1900000.00,
            'paid_amount' => 1000000.00,
            'status' => 'partial',
            'notes' => 'DP transfer Rp 1.000.000, pelunasan lusa.',
        ]);

        SaleItem::updateOrCreate([
            'sale_id' => $sale2->id,
            'product_id' => $tahuPutih->id,
        ], [
            'qty' => 50.00,
            'price' => 38000.00,
            'subtotal' => 1900000.00,
        ]);

        Payment::updateOrCreate([
            'sale_id' => $sale2->id,
            'date' => Carbon::today(),
        ], [
            'amount' => 1000000.00,
            'method' => 'transfer',
            'notes' => 'Uang muka / DP',
        ]);

        $sale3 = Sale::updateOrCreate(['invoice_no' => 'INV-'.date('Ymd').'-003'], [
            'date' => Carbon::today(),
            'customer_id' => $cust3->id,
            'user_id' => $admin->id,
            'total' => 550000.00,
            'paid_amount' => 0.00,
            'status' => 'unpaid',
            'notes' => 'Jatuh tempo 3 hari lagi',
        ]);

        SaleItem::updateOrCreate([
            'sale_id' => $sale3->id,
            'product_id' => $tahuSumedang->id,
        ], [
            'qty' => 10.00,
            'price' => 55000.00,
            'subtotal' => 550000.00,
        ]);

        // Historical data for daily 7-day chart & monthly trends
        $pastDaily = [
            ['days' => 1, 'sales' => 2850000, 'prod' => 280, 'failed' => 3],
            ['days' => 2, 'sales' => 3400000, 'prod' => 310, 'failed' => 5],
            ['days' => 3, 'sales' => 1950000, 'prod' => 220, 'failed' => 2],
            ['days' => 4, 'sales' => 4100000, 'prod' => 360, 'failed' => 4],
            ['days' => 5, 'sales' => 2600000, 'prod' => 290, 'failed' => 1],
            ['days' => 6, 'sales' => 3200000, 'prod' => 300, 'failed' => 3],
        ];

        foreach ($pastDaily as $idx => $d) {
            $pastDate = Carbon::today()->subDays($d['days']);
            $s = Sale::updateOrCreate(['invoice_no' => 'INV-'.$pastDate->format('Ymd').'-001'], [
                'date' => $pastDate,
                'customer_id' => $cust1->id,
                'user_id' => $admin->id,
                'total' => $d['sales'],
                'paid_amount' => $d['sales'],
                'status' => 'paid',
                'notes' => 'Pesanan reguler',
            ]);

            Production::updateOrCreate(['code' => 'PRD-'.$pastDate->format('Ymd').'-001'], [
                'date' => $pastDate,
                'product_id' => $tahuKuning->id,
                'user_id' => $admin->id,
                'qty_produced' => $d['prod'],
                'qty_failed' => $d['failed'],
                'notes' => 'Produksi harian',
            ]);
        }

        // Past months data
        $pastMonths = [
            ['subMonths' => 1, 'sales' => 74500000, 'prod' => 8200],
            ['subMonths' => 2, 'sales' => 68200000, 'prod' => 7600],
            ['subMonths' => 3, 'sales' => 81000000, 'prod' => 8900],
            ['subMonths' => 4, 'sales' => 62500000, 'prod' => 7100],
            ['subMonths' => 5, 'sales' => 59000000, 'prod' => 6800],
        ];

        foreach ($pastMonths as $m) {
            $mDate = Carbon::today()->subMonths($m['subMonths'])->startOfMonth()->addDays(10);
            Sale::updateOrCreate(['invoice_no' => 'INV-'.$mDate->format('Ymd').'-099'], [
                'date' => $mDate,
                'customer_id' => $cust2->id,
                'user_id' => $admin->id,
                'total' => $m['sales'],
                'paid_amount' => $m['sales'],
                'status' => 'paid',
                'notes' => 'Rekapitulasi penjualan bulanan',
            ]);

            Production::updateOrCreate(['code' => 'PRD-'.$mDate->format('Ymd').'-099'], [
                'date' => $mDate,
                'product_id' => $tahuKuning->id,
                'user_id' => $admin->id,
                'qty_produced' => $m['prod'],
                'qty_failed' => 120,
                'notes' => 'Rekapitulasi produksi bulanan',
            ]);
        }
    }
}
