<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_menu' => 'required|string|max:120',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori'  => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function index()
    {
        $menus = Menu::orderBy('kategori')->orderBy('nama_menu')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.form', ['menu' => new Menu()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['id_admin'] = session('admin_id');
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }
        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.form', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate($this->rules());
        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::disk('public')->delete($menu->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        } else {
            unset($data['gambar']);
        }
        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        try {
            $menu->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Menu sudah pernah dipesan sehingga tidak bisa dihapus. Ubah stoknya menjadi 0 sebagai gantinya.');
        }
        if ($menu->gambar) {
            Storage::disk('public')->delete($menu->gambar);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Menu dihapus.');
    }
}
