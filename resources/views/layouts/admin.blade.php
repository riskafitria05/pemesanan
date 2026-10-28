<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Admin') · Admin Kedai Online</title>
@include('partials.style')
</head>
<body>
<header class="top"><div class="wrap">
  <a class="brand" href="{{ route('admin.home') }}">Kedai<span>Admin</span></a>
  <nav aria-label="Navigasi admin">
    <a href="{{ route('admin.order.index') }}" class="{{ request()->routeIs('admin.order.*') ? 'on' : '' }}">Order</a>
    <a href="{{ route('admin.pembayaran.index') }}" class="{{ request()->routeIs('admin.pembayaran.*') ? 'on' : '' }}">Pembayaran</a>
    <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu.*') ? 'on' : '' }}">Menu</a>
    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'on' : '' }}">Laporan</a>
    <a href="{{ route('menu.index') }}">Lihat situs</a>
    <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">@csrf
      <button class="link" type="submit">Keluar ({{ session('admin_nama') }})</button></form>
  </nav>
</div></header>
<main><div class="wrap">
  @include('partials.flash')
  @yield('content')
</div></main>
</body>
</html>
