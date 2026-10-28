@extends('layouts.app')
@section('title','Data pemesan')
@section('content')
<h1>Data pemesan</h1>
<div class="cols">
  <form class="card" method="POST" action="{{ route('order.store') }}">@csrf
    <label for="nama_pemesan">Nama</label>
    <input id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}" required>
    <label for="nomor_telepon">Nomor telepon</label>
    <input id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" inputmode="tel" required>
    <label for="alamat">Alamat pengantaran</label>
    <textarea id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
    <label for="metode_pembayaran">Metode pembayaran</label>
    <select id="metode_pembayaran" name="metode_pembayaran" required>
      @foreach($metode as $m)<option @selected(old('metode_pembayaran')===$m)>{{ $m }}</option>@endforeach
    </select>
    <p style="margin-top:1.2rem"><button class="btn alt" type="submit">Buat pesanan</button></p>
  </form>
  <aside class="card" style="align-self:start">
    <h2>Ringkasan</h2>
    <p class="muted">{{ $count }} item di keranjang</p>
    <div class="stat">Rp {{ number_format($total,0,',','.') }}</div>
    <p class="muted">Setelah pesanan dibuat, unggah bukti pembayaran di halaman invoice. Stok dicek ulang saat pesanan dibuat.</p>
    <a href="{{ route('cart.index') }}">Ubah keranjang</a>
  </aside>
</div>
@endsection
