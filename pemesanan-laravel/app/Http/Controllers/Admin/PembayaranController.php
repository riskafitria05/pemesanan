<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'menunggu_verifikasi');

        $pembayarans = Pembayaran::with('order', 'admin')
            ->when($status !== 'semua', fn ($q) => $q->where('status_bayar', $status))
            ->latest('id_pembayaran')
            ->paginate(15)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayarans', 'status'));
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate(['aksi' => 'required|in:terima,tolak']);

        if ($pembayaran->order->status_order === 'dibatalkan') {
            return back()->with('error', 'Order sudah dibatalkan.');
        }

        if ($request->aksi === 'terima') {
            $pembayaran->update(['status_bayar' => 'terverifikasi', 'id_admin' => session('admin_id')]);
            if ($pembayaran->order->status_order === 'menunggu') {
                $pembayaran->order->update(['status_order' => 'diproses']);
            }
            return back()->with('success', 'Pembayaran diverifikasi, order diproses.');
        }

        $pembayaran->update(['status_bayar' => 'ditolak', 'id_admin' => session('admin_id')]);
        return back()->with('success', 'Pembayaran ditolak. Pelanggan dapat mengunggah ulang bukti.');
    }
}
