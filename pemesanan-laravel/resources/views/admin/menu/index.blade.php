@extends('layouts.admin')
@section('title','Kelola menu')
@section('content')
<div class="row"><h1 style="margin:0">Kelola menu</h1><a class="btn alt" href="{{ route('admin.menu.create') }}">Tambah menu</a></div>
@if($menus->isEmpty())
  <div class="card">Belum ada menu. Tambahkan menu pertama Anda.</div>
@else
<div class="scroll"><table>
  <thead><tr><th></th><th>Nama</th><th>Kategori</th><th class="num">Harga</th><th class="num">Stok</th><th></th></tr></thead>
  <tbody>@foreach($menus as $m)
    <tr>
      <td>@if($m->gambar)<img class="thumb" src="{{ asset('storage/'.$m->gambar) }}" alt="">@else<span class="thumb"></span>@endif</td>
      <td>{{ $m->nama_menu }}</td><td>{{ $m->kategori }}</td>
      <td class="num">Rp {{ number_format($m->harga,0,',','.') }}</td>
      <td class="num">{{ $m->stok }}</td>
      <td style="white-space:nowrap">
        <a class="btn ghost sm" href="{{ route('admin.menu.edit',$m) }}">Ubah</a>
        <form method="POST" action="{{ route('admin.menu.destroy',$m) }}" style="display:inline" onsubmit="return confirm('Hapus menu {{ addslashes($m->nama_menu) }}?')">@csrf @method('DELETE')
          <button class="btn bad sm" type="submit">Hapus</button></form>
      </td>
    </tr>
  @endforeach</tbody>
</table></div>
@endif
@endsection
