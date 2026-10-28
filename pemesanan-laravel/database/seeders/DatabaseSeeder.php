<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::updateOrCreate(
            ['username' => 'admin'],
            ['nama' => 'Administrator', 'email' => 'admin@example.com', 'password' => Hash::make('admin123')]
        );

        $menus = [
            ['Nasi Goreng Spesial', 'Nasi goreng dengan telur, ayam suwir, dan acar.', 'Makanan', 25000, 30],
            ['Mie Ayam Bakso', 'Mie kenyal dengan ayam kecap dan dua bakso.', 'Makanan', 22000, 25],
            ['Ayam Geprek', 'Ayam krispi diulek sambal bawang, nasi, lalapan.', 'Makanan', 24000, 20],
            ['Sate Ayam (10 tusuk)', 'Sate ayam bumbu kacang dengan lontong.', 'Makanan', 30000, 15],
            ['Es Teh Manis', 'Teh seduh dingin dengan gula aren.', 'Minuman', 6000, 60],
            ['Es Jeruk Peras', 'Jeruk peras segar tanpa pengawet.', 'Minuman', 10000, 40],
            ['Kopi Susu Gula Aren', 'Espresso, susu segar, gula aren.', 'Minuman', 16000, 35],
            ['Pisang Goreng Keju', 'Pisang goreng renyah, taburan keju dan susu.', 'Snack', 14000, 25],
            ['Kentang Goreng', 'Kentang goreng dengan saus sambal dan mayones.', 'Snack', 15000, 25],
        ];

        foreach ($menus as [$nama, $desk, $kat, $harga, $stok]) {
            Menu::updateOrCreate(
                ['nama_menu' => $nama],
                ['deskripsi' => $desk, 'kategori' => $kat, 'harga' => $harga, 'stok' => $stok, 'id_admin' => $admin->id_admin]
            );
        }
    }
}
