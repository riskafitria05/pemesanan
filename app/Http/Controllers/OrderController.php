<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public const METODE = ['Transfer Bank', 'E-Wallet', 'QRIS', 'Bayar di Tempat (COD)'];

    public function create()
    {
        $cart = session('cart', []);
        if (!$cart) {
            return redirect()->route('menu.index')->with('error', 'Keranjang masih kosong.');
        }

        $menus = Menu::whereIn('id_menu', array_keys($cart))->get();
        $total = $menus->sum(fn ($m) => $m->harga * $cart[$m->id_menu]);

        return view('customer.checkout', ['metode' => self::METODE, 'total' => $total, 'count' => array_sum($cart)]);
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (!$cart) {
            return redirect()->route('menu.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'nama_pemesan'      => 'required|string|max:100',
            'alamat'            => 'required|string|max:500',
            'nomor_telepon'     => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'metode_pembayaran' => 'required|in:' . implode(',', self::METODE),
        ], ['nomor_telepon.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, + atau -.']);

        try {
            $order = DB::transaction(function () use ($cart, $data) {
                $menus = Menu::whereIn('id_menu', array_keys($cart))->lockForUpdate()->get()->keyBy('id_menu');

                // include: Cek Stok Menu
                $total = 0;
                foreach ($cart as $id => $qty) {
                    $m = $menus[$id] ?? null;
                    if (!$m || !$m->cekStok($qty)) {
                        throw new \RuntimeException('Stok "' . ($m?->nama_menu ?? 'menu') . '" tidak mencukupi. Perbarui keranjang Anda.');
                    }
                    $total += DetailPesanan::hitungSubtotal($qty, $m->harga);
                }

                $order = Order::create($data + ['total_harga' => $total, 'status_order' => 'menunggu']);

                foreach ($cart as $id => $qty) {
                    $m = $menus[$id];
                    DetailPesanan::create([
                        'id_order'     => $order->id_order,
                        'id_menu'      => $m->id_menu,
                        'jumlah'       => $qty,
                        'harga_satuan' => $m->harga,
                        'subtotal'     => DetailPesanan::hitungSubtotal($qty, $m->harga),
                    ]);
                    $m->decrement('stok', $qty);
                }

                Pembayaran::create([
                    'id_order'     => $order->id_order,
                    'jumlah_bayar' => $total,
                    'status_bayar' => 'belum_bayar',
                ]);

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');
        $this->rememberOrder($order->id_order);

        return redirect()->route('order.show', $order)->with('success', 'Pesanan dibuat. Silakan lakukan pembayaran dan unggah bukti.');
    }

    public function cek()
    {
        return view('customer.cek');
    }

    public function cekPost(Request $request)
    {
        $request->validate(['id_order' => 'required|integer', 'nomor_telepon' => 'required|string']);

        $order = Order::find($request->id_order);
        $norm = fn ($s) => preg_replace('/\D/', '', $s);

        if (!$order || $norm($order->nomor_telepon) !== $norm($request->nomor_telepon)) {
            return back()->withInput()->with('error', 'Nomor order atau nomor telepon tidak cocok.');
        }

        $this->rememberOrder($order->id_order);
        return redirect()->route('order.show', $order);
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);
        $order->load('details.menu', 'pembayaran');
        return view('customer.invoice', compact('order'));
    }

    public function bayar(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        $pay = $order->pembayaran;
        if ($order->status_order === 'dibatalkan' || $pay->status_bayar === 'terverifikasi') {
            return back()->with('error', 'Pembayaran untuk pesanan ini tidak dapat diubah.');
        }

        $request->validate(['bukti_bayar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'],
            ['bukti_bayar.image' => 'Bukti bayar harus berupa gambar (JPG, PNG, WEBP).',
             'bukti_bayar.max' => 'Ukuran bukti bayar maksimal 2 MB.']);

        $path = $request->file('bukti_bayar')->store('bukti', 'public');

        $pay->update([
            'bukti_bayar'   => $path,
            'tanggal_bayar' => now(),
            'status_bayar'  => 'menunggu_verifikasi',
        ]);

        return back()->with('success', 'Bukti pembayaran terkirim. Admin akan memverifikasinya.');
    }

    private function rememberOrder(int $id): void
    {
        $mine = session('my_orders', []);
        $mine[] = $id;
        session(['my_orders' => array_unique($mine)]);
    }

    private function authorizeOrder(Order $order): void
    {
        abort_unless(in_array($order->id_order, session('my_orders', [])), 403,
            'Gunakan menu Cek Status dengan nomor order dan nomor telepon Anda.');
    }
}
