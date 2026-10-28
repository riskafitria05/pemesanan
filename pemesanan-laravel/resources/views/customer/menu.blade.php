@extends('layouts.app')
@section('title','Daftar menu')
@section('content')
<h1>Pilih menu hari ini</h1>
<form method="GET" class="bar">
  <div class="grow"><label for="q">Cari menu</label><input id="q" name="q" value="{{ request('q') }}" placeholder="Contoh: nasi goreng"></div>
  <div><label for="kategori">Kategori</label>
    <select id="kategori" name="kategori"><option value="">Semua</option>
      @foreach($kategoris as $k)<option value="{{ $k }}" @selected(request('kategori')===$k)>{{ $k }}</option>@endforeach
    </select></div>
  <button class="btn" type="submit">Terapkan</button>
  @if(request()->hasAny(['q','kategori']))<a class="btn ghost" href="{{ route('menu.index') }}">Reset</a>@endif
</form>

@if($menus->isEmpty())
  <div class="card">Tidak ada menu yang cocok. Ubah kata kunci atau pilih kategori lain.</div>
@else
<div class="grid">
@foreach($menus as $m)
  <article class="card menu-card">
    <div class="img" @if($m->gambar) style="background-image:url('{{ asset('storage/'.$m->gambar) }}')" role="img" aria-label="{{ $m->nama_menu }}" @endif>@unless($m->gambar)Belum ada foto@endunless</div>
    <div class="body">
      <span class="tag" style="align-self:flex-start">{{ $m->kategori }}</span>
      <h3>{{ $m->nama_menu }}</h3>
      <p class="muted" style="margin:0">{{ $m->deskripsi }}</p>
      <div class="price">Rp {{ number_format($m->harga,0,',','.') }}</div>
      @if($m->stok > 0)
      <p class="muted" style="margin:0">Stok {{ $m->stok }}</p>
      <form method="POST" action="{{ route('cart.add',$m) }}">@csrf
        <input type="number" name="jumlah" value="1" min="1" max="{{ $m->stok }}" aria-label="Jumlah {{ $m->nama_menu }}">
        <button class="btn alt" type="submit" style="flex:1">Tambah ke keranjang</button>
      </form>
      @else
      <p class="err" style="margin:0"><strong>Stok habis</strong></p>
      @endif
    </div>
  </article>
@endforeach
</div>
@endif
@endsection
