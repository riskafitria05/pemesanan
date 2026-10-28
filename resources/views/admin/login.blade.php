<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login admin · Kedai Online</title>
@include('partials.style')
</head>
<body>
<main><div class="wrap">
  <form class="card login" method="POST" action="{{ route('admin.login.post') }}">@csrf
    <h1>Login admin</h1>
    @include('partials.flash')
    <label for="username">Username</label>
    <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" autocomplete="current-password" required>
    <p style="margin-top:1.2rem"><button class="btn" type="submit">Masuk</button>
       <a class="btn ghost" href="{{ route('menu.index') }}">Kembali ke situs</a></p>
  </form>
</div></main>
</body>
</html>
