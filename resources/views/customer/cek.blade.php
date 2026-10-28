@extends('layouts.app')
@section('title','Cek status order')
@section('content')
<h1>Cek status order</h1>
<form class="card" method="POST" action="{{ route('order.cek.post') }}" style="max-width:460px">@csrf
  <label for="id_order">Nomor order</label>
  <input id="id_order" name="id_order" type="number" value="{{ old('id_order') }}" style="width:100%" required>
  <label for="nomor_telepon">Nomor telepon saat memesan</label>
  <input id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" inputmode="tel" required>
  <p style="margin-top:1.2rem"><button class="btn" type="submit">Lihat status</button></p>
</form>
@endsection
