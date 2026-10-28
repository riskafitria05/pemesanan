<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

// ===== Sisi Pelanggan =====
Route::get('/', [MenuController::class, 'index'])->name('menu.index');                 // Lihat Daftar Menu + Cari/Filter

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');       // Tambah ke Keranjang
Route::post('/keranjang/{menu}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{menu}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{menu}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [OrderController::class, 'create'])->name('order.create');     // Buat Order
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/cek-status', [OrderController::class, 'cek'])->name('order.cek');         // Cek Status Order
Route::post('/cek-status', [OrderController::class, 'cekPost'])->name('order.cek.post');
Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('order.show');  // Invoice
Route::post('/pesanan/{order}/bayar', [OrderController::class, 'bayar'])->name('order.bayar'); // Upload Bukti

// ===== Sisi Admin =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');

    Route::middleware(AdminAuth::class)->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', fn () => redirect()->route('admin.order.index'))->name('home');

        Route::resource('menu', Admin\MenuController::class)->except('show');          // Kelola Menu (CRUD)

        Route::get('order', [Admin\OrderController::class, 'index'])->name('order.index');       // Kelola Order
        Route::get('order/{order}', [Admin\OrderController::class, 'show'])->name('order.show');
        Route::patch('order/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('order.status');

        Route::get('pembayaran', [Admin\PembayaranController::class, 'index'])->name('pembayaran.index'); // Verifikasi Pembayaran
        Route::patch('pembayaran/{pembayaran}', [Admin\PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');

        Route::get('laporan', [Admin\LaporanController::class, 'index'])->name('laporan.index');  // Lihat Laporan Penjualan
    });
});
