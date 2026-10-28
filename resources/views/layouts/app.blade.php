<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Menu') · Kedai Online</title>
@include('partials.style')
</head>
<body>
<header class="top"><div class="wrap">
  <a class="brand" href="{{ route('menu.index') }}">Kedai<span>Online</span></a>
  <nav aria-label="Navigasi utama">
    <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.index') ? 'on' : '' }}">Menu</a>
    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'on' : '' }}">Keranjang ({{ array_sum(session('cart', [])) }})</a>
    <a href="{{ route('order.cek') }}" class="{{ request()->routeIs('order.cek*') ? 'on' : '' }}">Cek status order</a>
    <a href="{{ route('admin.login') }}">Admin</a>
  </nav>
</div></header>
<main><div class="wrap">
  @include('partials.flash')
  @yield('content')
</div></main>
</body>
</html>
