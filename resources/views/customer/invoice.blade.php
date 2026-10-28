@extends('layouts.app')
@section('title','Invoice #'.$order->id_order)
@section('content')
@php $p = $order->pembayaran; @endphp
<div class="row">
  <h1 style="margin:0">Invoice #{{ $order->id_order }}</h1>
  <div><span class="badge {{ $order->status_order }}">Order: {{ $order->status_order }}</span>
       <span class="badge {{ $p->status_bayar }}">Bayar: {{ str_replace('_',' ',$p->status_bayar) }}</span></div>
</div>
<div class="cols">
  <section class="card">
    <h2>Pemesan</h2>
    <p style="margin:0">{{ $order->nama_pemesan }}<br>{{ $order->nomor_telepon }}<br>{{ $order->alamat }}</p>
    <p class="muted">Dipesan {{ $order->created_at->format('d M Y H:i') }} · {{ $order->metode_pembayaran }}</p>
  </section>
  <section class="card">
    <h2>Pembayaran</h2>
    <div class="stat">Rp {{ number_format($order->total_harga,0,',','.') }}</div>
    @if($p->bukti_bayar)
      <p class="muted">Bukti terkirim {{ $p->tanggal_bayar?->format('d M Y H:i') }}</p>
      <img class="bukti" src="{{ asset('storage/'.$p->bukti_bayar) }}" alt="Bukti pembayaran">
    @endif
    @if($p->status_bayar==='ditolak')<p class="err"><strong>Bukti ditolak admin.</strong> Unggah ulang bukti yang jelas.</p>@endif
    @if($order->status_order!=='dibatalkan' && $p->status_bayar!=='terverifikasi')
      <form method="POST" action="{{ route('order.bayar',$order) }}" enctype="multipart/form-data">@csrf
        <label for="bukti_bayar">{{ $p->bukti_bayar ? 'Unggah ulang bukti' : 'Unggah bukti pembayaran' }} (JPG/PNG, maks 2 MB)</label>
        <input id="bukti_bayar" type="file" name="bukti_bayar" accept="image/*" required>
        <p><button class="btn alt" type="submit">Kirim bukti</button></p>
      </form>
    @endif
  </section>
</div>
<h2 style="margin-top:1.4rem">Item pesanan</h2>
<div class="scroll"><table>
  <thead><tr><th>Menu</th><th class="num">Harga</th><th class="num">Jumlah</th><th class="num">Subtotal</th></tr></thead>
  <tbody>@foreach($order->details as $d)
    <tr><td>{{ $d->menu->nama_menu }}</td><td class="num">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td><td class="num">{{ $d->jumlah }}</td><td class="num">Rp {{ number_format($d->subtotal,0,',','.') }}</td></tr>
  @endforeach</tbody>
  <tfoot><tr><th colspan="3" class="num">Total</th><th class="num">Rp {{ number_format($order->total_harga,0,',','.') }}</th></tr></tfoot>
</table></div>
<p class="muted">Simpan nomor order <strong>#{{ $order->id_order }}</strong> untuk mengecek status lagi di menu "Cek status order".</p>
@endsection
