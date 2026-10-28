@extends('layouts.admin')
@php $edit = $menu->exists; @endphp
@section('title', $edit ? 'Ubah menu' : 'Tambah menu')
@section('content')
<h1>{{ $edit ? 'Ubah menu' : 'Tambah menu' }}</h1>
<form class="card" style="max-width:560px" method="POST" enctype="multipart/form-data"
      action="{{ $edit ? route('admin.menu.update',$menu) : route('admin.menu.store') }}">@csrf
  @if($edit) @method('PUT') @endif
  <label for="nama_menu">Nama menu</label>
  <input id="nama_menu" name="nama_menu" value="{{ old('nama_menu',$menu->nama_menu) }}" required>
  <label for="kategori">Kategori</label>
  <input id="kategori" name="kategori" list="kat" value="{{ old('kategori',$menu->kategori) }}" required>
  <datalist id="kat"><option>Makanan</option><option>Minuman</option><option>Snack</option></datalist>
  <label for="deskripsi">Deskripsi</label>
  <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi',$menu->deskripsi) }}</textarea>
  <div style="display:flex;gap:1rem;flex-wrap:wrap">
    <div><label for="harga">Harga (Rp)</label><input id="harga" type="number" name="harga" min="0" step="500" style="width:10rem" value="{{ old('harga',$menu->harga ? (int)$menu->harga : '') }}" required></div>
    <div><label for="stok">Stok</label><input id="stok" type="number" name="stok" min="0" style="width:7rem" value="{{ old('stok',$menu->stok ?? 0) }}" required></div>
  </div>
  <label for="gambar">Foto menu (JPG/PNG, maks 2 MB)</label>
  @if($edit && $menu->gambar)<img class="thumb" style="width:96px;height:96px;margin-bottom:.4rem" src="{{ asset('storage/'.$menu->gambar) }}" alt="Foto saat ini">@endif
  <input id="gambar" type="file" name="gambar" accept="image/*">
  <p style="margin-top:1.2rem"><button class="btn" type="submit">Simpan menu</button>
     <a class="btn ghost" href="{{ route('admin.menu.index') }}">Batal</a></p>
</form>
@endsection
