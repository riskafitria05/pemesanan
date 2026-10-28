@extends('layouts.admin')
@section('title','Order #'.$order->id_order)
@section('content')
@php $p = $order->pembayaran; @endphp
<div class="row"><h1 style="margin:0">Order #{{ $order->id_order }}</h1><a class="btn ghost" href="{{ route('admin.order.index') }}">Kembali</a></div>
<div class="cols">
  <section class="card">
    <h2>Pemesan</h2>
    <p style="margin:0">{{ $order->nama_pemesan }}<br>{{ $order->nomor_telepon }}<br>{{ $order->alamat }}</p>
    <p class="muted">{{ $order->created_at->format('d M Y H:i') }} · {{ $order->metode_pembayaran }}</p>
    <h3>Ubah status order</h3>
    @if($order->status_order==='dibatalkan')
      <p class="muted">Order dibatalkan dan tidak bisa diubah lagi.</p>
    @else
    <form method="POST" action="{{ route('admin.order.status',$order) }}" style="display:flex;gap:.5rem;align-items:center">@csrf @method('PATCH')
      <select name="status_order" aria-label="Status order" style="width:auto">
        @foreach($statuses as $s)<option value="{{ $s }}" @selected($order->status_order===$s)>{{ ucfirst($s) }}</option>@endforeach
      </select>
      <button class="btn" type="submit" onclick="return this.form.status_order.value!=='dibatalkan'||confirm('Batalkan order ini? Stok akan dikembalikan.')">Simpan status</button>
    </form>
    @endif
  </section>
  <section class="card">
    <h2>Pembayaran</h2>
    <span class="badge {{ $p->status_bayar }}">{{ str_replace('_',' ',$p->status_bayar) }}</span>
    <div class="stat">Rp {{ number_format($p->jumlah_bayar,0,',','.') }}</div>
    @if($p->admin)<p class="muted">Diverifikasi oleh {{ $p->admin->nama }}</p>@endif
    @if($p->bukti_bayar)<img class="bukti" src="{{ asset('storage/'.$p->bukti_bayar) }}" alt="Bukti pembayaran">
      <p class="muted">Dikirim {{ $p->tanggal_bayar?->format('d M Y H:i') }}</p>
    @else<p class="muted">Pelanggan belum mengunggah bukti.</p>@endif
    @if($p->status_bayar==='menunggu_verifikasi' && $order->status_order!=='dibatalkan')
      <form method="POST" action="{{ route('admin.pembayaran.verifikasi',$p) }}" style="display:flex;gap:.5rem">@csrf @method('PATCH')
        <button class="btn" name="aksi" value="terima">Terima pembayaran</button>
        <button class="btn bad" name="aksi" value="tolak">Tolak bukti</button>
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
@endsection
