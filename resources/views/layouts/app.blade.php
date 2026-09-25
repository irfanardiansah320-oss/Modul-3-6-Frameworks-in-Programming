<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Activity Manager</title>
</head>
<body>
    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif
    @yield('content')
</body>
</html>