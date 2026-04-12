<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Admin Dealer',
                'email'    => 'admin@dealer.com',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ],
            [
                'name'     => 'Karyawan Showroom',
                'email'    => 'staff@dealer.com',
                'password' => Hash::make('password123'),
                'role'     => 'karyawan',
            ],
            [
                'name'     => 'Andi Pembeli',
                'email'    => 'pembeli@gmail.com',
                'password' => Hash::make('password123'),
                'role'     => 'pelanggan',
            ],
            [
                'name'     => 'Pemilik Showroom (Bos)',
                'email'    => 'bos@dealer.com',
                'password' => Hash::make('password123'),
                'role'     => 'bos',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
