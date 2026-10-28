@extends('layouts.admin')
@section('title','Verifikasi pembayaran')
@section('content')
<h1>Verifikasi pembayaran</h1>
<form method="GET" class="bar">
  <div><label for="status">Tampilkan</label>
    <select id="status" name="status">
      @foreach(['menunggu_verifikasi'=>'Menunggu verifikasi','terverifikasi'=>'Terverifikasi','ditolak'=>'Ditolak','belum_bayar'=>'Belum bayar','semua'=>'Semua'] as $v=>$l)
        <option value="{{ $v }}" @selected($status===$v)>{{ $l }}</option>@endforeach
    </select></div>
  <button class="btn" type="submit">Terapkan</button>
</form>
@if($pembayarans->isEmpty())
  <div class="card">Tidak ada pembayaran dengan status ini.</div>
@else
<div class="scroll"><table>
  <thead><tr><th>Order</th><th>Pemesan</th><th class="num">Jumlah</th><th>Dikirim</th><th>Status</th><th>Bukti</th><th></th></tr></thead>
  <tbody>@foreach($pembayarans as $p)
    <tr>
      <td><a href="{{ route('admin.order.show',$p->id_order) }}">#{{ $p->id_order }}</a></td>
      <td>{{ $p->order->nama_pemesan }}<br><span class="muted">{{ $p->order->metode_pembayaran }}</span></td>
      <td class="num">Rp {{ number_format($p->jumlah_bayar,0,',','.') }}</td>
      <td>{{ $p->tanggal_bayar?->format('d M Y H:i') ?? '-' }}</td>
      <td><span class="badge {{ $p->status_bayar }}">{{ str_replace('_',' ',$p->status_bayar) }}</span></td>
      <td>@if($p->bukti_bayar)<a href="{{ asset('storage/'.$p->bukti_bayar) }}" target="_blank" rel="noopener">Lihat bukti</a>@else-@endif</td>
      <td style="white-space:nowrap">
        @if($p->status_bayar==='menunggu_verifikasi')
        <form method="POST" action="{{ route('admin.pembayaran.verifikasi',$p) }}" style="display:inline">@csrf @method('PATCH')
          <button class="btn sm" name="aksi" value="terima">Terima</button>
          <button class="btn bad sm" name="aksi" value="tolak">Tolak</button></form>
        @endif
      </td>
    </tr>
  @endforeach</tbody>
</table></div>
<div style="margin-top:1rem">{{ $pembayarans->links('partials.pager') }}</div>
@endif
@endsection
