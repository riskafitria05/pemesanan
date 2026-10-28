@extends('layouts.app')
@section('title','Keranjang')
@section('content')
<h1>Keranjang</h1>
@if(!$items)
  <div class="card">Keranjang masih kosong. <a href="{{ route('menu.index') }}">Pilih menu</a> dulu.</div>
@else
<div class="scroll"><table>
  <thead><tr><th>Menu</th><th class="num">Harga</th><th>Jumlah</th><th class="num">Subtotal</th><th></th></tr></thead>
  <tbody>
  @foreach($items as $i)
    <tr>
      <td>{{ $i['menu']->nama_menu }}</td>
      <td class="num">Rp {{ number_format($i['menu']->harga,0,',','.') }}</td>
      <td>
        <form method="POST" action="{{ route('cart.update',$i['menu']) }}" style="display:flex;gap:.4rem">@csrf @method('PATCH')
          <input type="number" name="jumlah" value="{{ $i['qty'] }}" min="0" max="{{ $i['menu']->stok }}" aria-label="Jumlah {{ $i['menu']->nama_menu }}">
          <button class="btn ghost sm" type="submit">Ubah</button>
        </form>
      </td>
      <td class="num">Rp {{ number_format($i['subtotal'],0,',','.') }}</td>
      <td><form method="POST" action="{{ route('cart.remove',$i['menu']) }}">@csrf @method('DELETE')<button class="btn bad sm" type="submit">Hapus</button></form></td>
    </tr>
  @endforeach
  </tbody>
  <tfoot><tr><th colspan="3" class="num">Total</th><th class="num">Rp {{ number_format($total,0,',','.') }}</th><th></th></tr></tfoot>
</table></div>
<div class="row" style="margin-top:1rem">
  <a class="btn ghost" href="{{ route('menu.index') }}">Tambah menu lain</a>
  <a class="btn alt" href="{{ route('order.create') }}">Lanjut ke pemesanan</a>
</div>
@endif
@endsection
