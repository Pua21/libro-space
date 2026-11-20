<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Libro Space')</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <header class="shell-header">
        <strong>Libro Space</strong>
        <span>@yield('role')</span>
    </header>

    <div class="shell">
        <nav class="shell-nav" aria-label="Navigasi utama">
            @yield('navigation')
        </nav>

        <main id="konten">
            @yield('content')
        </main>
    </div>
</body>
</html>