<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $menus = Menu::whereIn('id_menu', array_keys($cart))->get()->keyBy('id_menu');

        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            if (!isset($menus[$id])) {
                continue;
            }
            $m = $menus[$id];
            $subtotal = $m->harga * $qty;
            $total += $subtotal;
            $items[] = ['menu' => $m, 'qty' => $qty, 'subtotal' => $subtotal];
        }

        return view('customer.cart', compact('items', 'total'));
    }

    public function add(Request $request, Menu $menu)
    {
        $qty = max(1, (int) $request->input('jumlah', 1));
        $cart = session('cart', []);
        $new = ($cart[$menu->id_menu] ?? 0) + $qty;

        if (!$menu->cekStok($new)) {
            return back()->with('error', "Stok {$menu->nama_menu} tersisa {$menu->stok}.");
        }

        $cart[$menu->id_menu] = $new;
        session(['cart' => $cart]);

        return back()->with('success', "{$menu->nama_menu} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Menu $menu)
    {
        $qty = (int) $request->input('jumlah', 1);
        $cart = session('cart', []);

        if ($qty < 1) {
            unset($cart[$menu->id_menu]);
        } elseif (!$menu->cekStok($qty)) {
            return back()->with('error', "Stok {$menu->nama_menu} tersisa {$menu->stok}.");
        } else {
            $cart[$menu->id_menu] = $qty;
        }

        session(['cart' => $cart]);
        return back();
    }

    public function remove(Menu $menu)
    {
        $cart = session('cart', []);
        unset($cart[$menu->id_menu]);
        session(['cart' => $cart]);

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }
}
