@extends('layouts.admin')
@section('title','Kelola order')
@section('content')
<h1>Order masuk</h1>
<form method="GET" class="bar">
  <div><label for="status">Status order</label>
    <select id="status" name="status"><option value="">Semua</option>
      @foreach($statuses as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach
    </select></div>
  <button class="btn" type="submit">Terapkan</button>
</form>
@if($orders->isEmpty())
  <div class="card">Belum ada order dengan status ini.</div>
@else
<div class="scroll"><table>
  <thead><tr><th>#</th><th>Pemesan</th><th>Tanggal</th><th class="num">Total</th><th>Order</th><th>Bayar</th><th></th></tr></thead>
  <tbody>@foreach($orders as $o)
    <tr>
      <td>{{ $o->id_order }}</td><td>{{ $o->nama_pemesan }}<br><span class="muted">{{ $o->nomor_telepon }}</span></td>
      <td>{{ $o->created_at->format('d M Y H:i') }}</td>
      <td class="num">Rp {{ number_format($o->total_harga,0,',','.') }}</td>
      <td><span class="badge {{ $o->status_order }}">{{ $o->status_order }}</span></td>
      <td><span class="badge {{ $o->pembayaran?->status_bayar }}">{{ str_replace('_',' ',$o->pembayaran?->status_bayar) }}</span></td>
      <td><a class="btn ghost sm" href="{{ route('admin.order.show',$o) }}">Detail</a></td>
    </tr>
  @endforeach</tbody>
</table></div>
<div style="margin-top:1rem">{{ $orders->links('partials.pager') }}</div>
@endif
@endsection
