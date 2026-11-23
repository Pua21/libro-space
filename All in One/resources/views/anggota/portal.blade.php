<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f7f8fa">
    <meta name="description" content="Beranda anggota, katalog buku, dan pinjaman perpustakaan Libro Space.">
    <title>Beranda Anggota | Libro Space</title>
    <link rel="stylesheet" href="{{ asset('web-anggota/base.css') }}">
    <link rel="stylesheet" href="{{ asset('web-anggota/styles.css') }}">
    <script src="{{ asset('web-anggota/demo-store.js') }}" defer></script>
    <script src="{{ asset('web-anggota/app.js') }}" defer></script>
</head>
<body>
    <a class="skip-link" href="#konten">Langsung ke konten</a>
    <div id="app"></div>
    <dialog id="dialog" aria-labelledby="dialog-title"></dialog>
    <div id="toast" class="toast" role="status" hidden></div>
    <noscript>Aktifkan JavaScript untuk memakai portal Libro Space.</noscript>

    @if(Auth::check() || session('authenticated_user'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const memberName = "{{ Auth::user()->name ?? (session('authenticated_user.nama') ?? '') }}";
                const memberEmail = "{{ Auth::user()->email ?? (session('authenticated_user.email') ?? '') }}";
                if (memberName && window.LibroDemo) {
                    const currentState = window.LibroDemo.read();
                    const demoMember = currentState?.members?.find(m => m.id === window.LibroDemo.memberId);
                    if (demoMember && demoMember.name === 'Rina Maharani') {
                        window.LibroDemo.update((data) => {
                            const target = data.members.find(m => m.id === window.LibroDemo.memberId);
                            if (target) {
                                target.name = memberName;
                                if (memberEmail) target.email = memberEmail;
                            }
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
