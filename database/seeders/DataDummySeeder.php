<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Setup Users (Pastikan UserSeeder dijalankan atau setup manual di sini)
        $admin = User::firstOrCreate(['email' => 'admin@dealer.com'], [
            'name' => 'Admin Dealer',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $karyawan = User::firstOrCreate(['email' => 'staff@dealer.com'], [
            'name' => 'Karyawan Showroom',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $pelanggan = User::firstOrCreate(['email' => 'pembeli@gmail.com'], [
            'name' => 'Andi Pembeli',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
        ]);

        $bos = User::firstOrCreate(['email' => 'bos@dealer.com'], [
            'name' => 'Pemilik Showroom (Bos)',
            'password' => Hash::make('password123'),
            'role' => 'bos',
        ]);

        // 2. Setup Products
        $products = [
            [
                'nama_produk' => 'Honda Beat CBS ISS',
                'stok' => 15,
                'harga' => 18500000,
                'deskripsi' => 'Skuter matik terlaris dengan fitur Idling Stop System yang hemat bahan bakar.',
                'gambar' => null
            ],
            [
                'nama_produk' => 'Yamaha NMAX 155 Connected',
                'stok' => 8,
                'harga' => 32000000,
                'deskripsi' => 'Maxi skuter yang nyaman dengan fitur Y-Connect.',
                'gambar' => null
            ],
            [
                'nama_produk' => 'Honda CBR250RR',
                'stok' => 3,
                'harga' => 63500000,
                'deskripsi' => 'Motor sport fairing kencang dengan Quick Shifter.',
                'gambar' => null
            ],
            [
                'nama_produk' => 'Vespa Sprint 150 I-Get',
                'stok' => 5,
                'harga' => 54000000,
                'deskripsi' => 'Skuter premium bernuansa klasik Eropa yang elegan.',
                'gambar' => null
            ],
        ];

        $productModels = [];
        foreach ($products as $pData) {
            $productModels[] = Product::firstOrCreate(['nama_produk' => $pData['nama_produk']], $pData);
        }

        // 3. Setup Orders & Transactions
        // Order 1: Completed by Karyawan (Manual Cash)
        $order1 = Order::create([
            'user_id' => $pelanggan->id,
            'product_id' => $productModels[0]->id, // Beat
            'nama_pembeli' => 'Budi Setiawan', // Walk-in customer logged by Karyawan
            'total_harga' => $productModels[0]->harga,
            'deskripsi_tambahan' => 'Warna Merah',
            'status' => 'completed',
            'created_at' => Carbon::now()->subDays(5),
            'updated_at' => Carbon::now()->subDays(4),
        ]);

        Transaction::create([
            'order_id' => $order1->id,
            'transaction_id_midtrans' => 'MANUAL-' . time() . '1',
            'payment_type' => 'cash',
            'amount' => $order1->total_harga,
            'payment_time' => Carbon::now()->subDays(4),
        ]);

        // Order 2: Completed via Midtrans
        $order2 = Order::create([
            'user_id' => $pelanggan->id,
            'product_id' => $productModels[1]->id, // NMAX
            'nama_pembeli' => 'Andi Pembeli',
            'total_harga' => $productModels[1]->harga,
            'deskripsi_tambahan' => 'Kirim ke rumah, jalan soedirman',
            'status' => 'completed',
            'snap_token' => 'dummy_token_123',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        Transaction::create([
            'order_id' => $order2->id,
            'transaction_id_midtrans' => 'MID_SANDBOX_' . time() . '2',
            'payment_type' => 'gopay',
            'amount' => $order2->total_harga,
            'payment_time' => Carbon::now()->subDays(2),
        ]);

        // Order 3: Pending
        Order::create([
            'user_id' => $pelanggan->id,
            'product_id' => $productModels[3]->id, // Vespa
            'nama_pembeli' => 'Siti Aisyah',
            'total_harga' => $productModels[3]->harga,
            'deskripsi_tambahan' => 'Helm free sertakan',
            'status' => 'pending',
            'created_at' => Carbon::now()->subDays(1),
            'updated_at' => Carbon::now()->subDays(1),
        ]);
        
        // Decrement Stok untuk orderan yg completed
        $productModels[0]->decrement('stok', 1);
        $productModels[1]->decrement('stok', 1);
    }
}
