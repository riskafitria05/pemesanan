<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->when($request->filled('q'), fn ($q) => $q->where('nama_menu', 'like', '%' . $request->q . '%'))
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->orderBy('kategori')->orderBy('nama_menu')
            ->get();

        $kategoris = Menu::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('customer.menu', compact('menus', 'kategoris'));
    }
}
