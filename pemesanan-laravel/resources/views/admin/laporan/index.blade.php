@extends('layouts.admin')
@section('title','Laporan penjualan')
@section('content')
<h1>Laporan penjualan</h1>
<form method="GET" class="bar">
  <div><label for="dari">Dari tanggal</label><input id="dari" type="date" name="dari" value="{{ $dari }}" style="width:auto"></div>
  <div><label for="sampai">Sampai tanggal</label><input id="sampai" type="date" name="sampai" value="{{ $sampai }}" style="width:auto"></div>
  <button class="btn" type="submit">Tampilkan</button>
  <button class="btn ghost" type="button" onclick="window.print()">Cetak</button>
</form>
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-bottom:1.4rem">
  <div class="card"><div class="muted">Pendapatan terverifikasi</div><div class="stat">Rp {{ number_format($ringkasan['pendapatan'],0,',','.') }}</div></div>
  <div class="card"><div class="muted">Jumlah order (tanpa batal)</div><div class="stat">{{ $ringkasan['jumlah_order'] }}</div></div>
  <div class="card"><div class="muted">Belum lunas</div><div class="stat">{{ $ringkasan['belum_lunas'] }}</div></div>
</div>
<div class="cols">
  <section>
    <h2>Menu terlaris</h2>
    @if($terlaris->isEmpty())<div class="card">Belum ada penjualan pada rentang ini.</div>@else
    <div class="scroll"><table><thead><tr><th>Menu</th><th class="num">Terjual</th><th class="num">Omzet</th></tr></thead><tbody>
      @foreach($terlaris as $t)<tr><td>{{ $t->nama_menu }}</td><td class="num">{{ $t->terjual }}</td><td class="num">Rp {{ number_format($t->omzet,0,',','.') }}</td></tr>@endforeach
    </tbody></table></div>@endif
  </section>
  <section>
    <h2>Daftar order</h2>
    @if($orders->isEmpty())<div class="card">Tidak ada order pada rentang ini.</div>@else
    <div class="scroll"><table><thead><tr><th>#</th><th>Tanggal</th><th class="num">Total</th><th>Bayar</th></tr></thead><tbody>
      @foreach($orders as $o)<tr><td><a href="{{ route('admin.order.show',$o) }}">{{ $o->id_order }}</a></td><td>{{ $o->created_at->format('d M Y') }}</td>
      <td class="num">Rp {{ number_format($o->total_harga,0,',','.') }}</td>
      <td><span class="badge {{ $o->pembayaran?->status_bayar }}">{{ str_replace('_',' ',$o->pembayaran?->status_bayar) }}</span></td></tr>@endforeach
    </tbody></table></div>@endif
  </section>
</div>
@endsection
