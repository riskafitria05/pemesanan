<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('pembayaran')
            ->when($request->filled('status'), fn ($q) => $q->where('status_order', $request->status))
            ->latest('id_order')
            ->paginate(15)->withQueryString();

        return view('admin.order.index', ['orders' => $orders, 'statuses' => Order::STATUS]);
    }

    public function show(Order $order)
    {
        $order->load('details.menu', 'pembayaran.admin');
        return view('admin.order.show', ['order' => $order, 'statuses' => Order::STATUS]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status_order' => 'required|in:' . implode(',', Order::STATUS)]);
        $baru = $request->status_order;

        if ($order->status_order === 'dibatalkan') {
            return back()->with('error', 'Order yang dibatalkan tidak dapat diubah lagi.');
        }

        DB::transaction(function () use ($order, $baru) {
            if ($baru === 'dibatalkan') {
                // kembalikan stok
                foreach ($order->details()->with('menu')->get() as $d) {
                    $d->menu?->increment('stok', $d->jumlah);
                }
            }
            $order->update(['status_order' => $baru]);
        });

        return back()->with('success', 'Status order diubah menjadi ' . $baru . '.');
    }
}
