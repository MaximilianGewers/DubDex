@extends('layouts.app')

@section('content')
    <div class="space-y-12">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="space-y-4">
                <a href="{{ route('animes.index') }}" class="text-sm font-medium text-sky-300 transition hover:text-sky-200">← Back to all animes</a>
                <div>
                    <h1 class="text-4xl font-bold tracking-tight text-white">{{ $anime['title'] }}</h1>
                    <p class="mt-3 max-w-3xl text-lg text-slate-300">{{ $anime['synopsis'] }}</p>
                </div>
                <div class="flex flex-wrap gap-2 text-xs font-semibold">
                    @foreach ($anime['genres'] as $genre)
                        <span class="rounded-full bg-slate-800 px-3 py-1 uppercase tracking-wide text-slate-300">{{ $genre }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex gap-6 text-sm">
                <div>
                    <div class="text-3xl font-semibold text-white">{{ count($anime['characters']) }}</div>
                    <div class="text-slate-400">Characters</div>
                </div>
                <div>
                    <div class="text-3xl font-semibold text-white">{{ count($anime['voice_actors']) }}</div>
                    <div class="text-slate-400">Voice Actors</div>
                </div>
            </div>
        </div>

        <section class="space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-white">Main Characters</h2>
                <p class="text-sm text-slate-400">Meet the heroes and villains that define the series.</p>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($anime['characters'] as $character)
                    <div class="rounded-xl border border-slate-800 bg-slate-900/50 p-6 shadow">
                        <h3 class="text-xl font-semibold text-white">{{ $character['name'] }}</h3>
                        <p class="mt-2 text-sm text-slate-300">{{ $character['role'] }}</p>
                        <div class="mt-4 space-y-2 text-sm">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Voice Actors</p>
                            <ul class="space-y-1">
                                @foreach ($character['voice_actors'] as $voiceActor)
                                    <li class="flex items-center justify-between rounded-lg bg-slate-950/60 px-3 py-2">
                                        <span class="font-medium text-slate-100">{{ $voiceActor['name'] }}</span>
                                        <span class="text-xs text-slate-400">{{ $voiceActor['language'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Voice Actors</h2>
                    <p class="text-sm text-slate-400">The cast behind the characters.</p>
                </div>
                <a href="{{ route('voice-actors.index') }}" class="text-sm font-medium text-sky-300 transition hover:text-sky-200">View full voice actor directory →</a>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($anime['voice_actors'] as $voiceActor)
                    <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4">
                        <h3 class="text-lg font-semibold text-white">{{ $voiceActor['name'] }}</h3>
                        <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">{{ $voiceActor['language'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
