<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f4f6fa">
    <meta name="description" content="Dashboard operasional sirkulasi perpustakaan Libro Space.">
    <title>Dashboard Operasional | Libro Space</title>
    <link rel="stylesheet" href="{{ asset('web-petugas/base.css') }}">
    <link rel="stylesheet" href="{{ asset('web-petugas/styles.css') }}">
    <script src="{{ asset('web-petugas/demo-store.js') }}" defer></script>
    <script src="{{ asset('web-petugas/app.js') }}" defer></script>
</head>
<body>
    <a class="skip-link" href="#konten">Langsung ke konten</a>
    <div id="app"></div>
    <dialog id="dialog" aria-labelledby="dialog-title"></dialog>
    <div id="toast" class="toast" role="status" hidden></div>
    <noscript>Aktifkan JavaScript untuk memakai dashboard Libro Space.</noscript>

    @if(Auth::check() || session('authenticated_user'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const staffName = "{{ Auth::user()->name ?? (session('authenticated_user.nama') ?? '') }}";
                const staffEmail = "{{ Auth::user()->email ?? (session('authenticated_user.email') ?? '') }}";
                if (staffName && window.LibroDemo) {
                    const currentState = window.LibroDemo.read();
                    if (currentState && currentState.staff && (!currentState.staff.name || currentState.staff.name === 'Petugas Demo')) {
                        window.LibroDemo.update((data) => {
                            data.staff.name = staffName;
                            if (staffEmail) data.staff.email = staffEmail;
                        });
                    }
                }
            } catch (e) {
                console.error(e);
            }
        });
    </script>
    @endif
</body>
</html>
