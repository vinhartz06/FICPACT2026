<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk...</title>
</head>
<body>
@if (session('auth_token'))
<script>
(function () {
  try {
    var u = @json(session('auth_user'));
    localStorage.setItem('auth_token', @json(session('auth_token')));
    localStorage.setItem('user', JSON.stringify(u));
    localStorage.removeItem('guest_mode');
  } catch (e) {}
  window.location.replace(@json(url('/game')));
})();
</script>
<noscript><p>JavaScript diperlukan. <a href="{{ url('/game') }}">Lanjut ke dashboard</a></p></noscript>
@else
<script>window.location.replace(@json(route('login')));</script>
@endif
</body>
</html>
