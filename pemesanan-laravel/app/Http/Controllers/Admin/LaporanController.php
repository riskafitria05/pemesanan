<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->toDateString());

        $orders = Order::with('pembayaran')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->where('status_order', '!=', 'dibatalkan')
            ->orderByDesc('id_order')
            ->get();

        $terbayar = $orders->filter(fn ($o) => $o->pembayaran?->status_bayar === 'terverifikasi');
        $ringkasan = [
            'jumlah_order' => $orders->count(),
            'pendapatan'   => $terbayar->sum('total_harga'),
            'belum_lunas'  => $orders->count() - $terbayar->count(),
        ];

        $terlaris = DetailPesanan::query()
            ->join('menus', 'menus.id_menu', '=', 'detail_pesanans.id_menu')
            ->join('orders', 'orders.id_order', '=', 'detail_pesanans.id_order')
            ->whereDate('orders.created_at', '>=', $dari)
            ->whereDate('orders.created_at', '<=', $sampai)
            ->where('orders.status_order', '!=', 'dibatalkan')
            ->groupBy('menus.id_menu', 'menus.nama_menu')
            ->select('menus.nama_menu', DB::raw('SUM(detail_pesanans.jumlah) as terjual'), DB::raw('SUM(detail_pesanans.subtotal) as omzet'))
            ->orderByDesc('terjual')
            ->limit(5)->get();

        return view('admin.laporan.index', compact('orders', 'ringkasan', 'terlaris', 'dari', 'sampai'));
    }
}
