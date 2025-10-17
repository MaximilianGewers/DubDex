<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'DubDex Anime Library' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-slate-800 bg-slate-950/70 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-6">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-sky-400 hover:text-sky-300">
                    DubDex
                </a>
                <nav class="flex items-center gap-4 text-sm font-medium">
                    <a href="{{ route('animes.index') }}" class="transition hover:text-sky-300 {{ request()->routeIs('animes.*') ? 'text-sky-300' : 'text-slate-300' }}">Animes</a>
                    <a href="{{ route('voice-actors.index') }}" class="transition hover:text-sky-300 {{ request()->routeIs('voice-actors.*') ? 'text-sky-300' : 'text-slate-300' }}">Voice Actors</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto min-h-[calc(100vh-5rem)] w-full max-w-6xl px-4 py-12">
            @yield('content')
        </main>

        <footer class="border-t border-slate-800 bg-slate-950/70">
            <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-slate-500">
                Built with Laravel • {{ now()->format('Y') }}
            </div>
        </footer>
    </body>
</html>
