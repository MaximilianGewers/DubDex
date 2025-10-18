@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-bold tracking-tight text-white">Explore the Anime Library</h1>
            <p class="mt-3 text-lg text-slate-300">
                Browse a curated collection of fan-favourite series. Select an anime to discover its main characters
                and the talented voice actors who bring them to life.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($animes as $anime)
                <x-resource-card :href="route('animes.show', $anime['id'])">
                    <x-slot name="header">
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="text-2xl font-semibold text-white group-hover:text-sky-300">{{ $anime['title'] }}</h2>
                            <span class="rounded-full bg-sky-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-300">
                                {{ str_pad(count($anime['characters']), 2, '0', STR_PAD_LEFT) }} Characters
                            </span>
                        </div>
                    </x-slot>

                    <p class="text-sm text-slate-300">{{ $anime['synopsis'] }}</p>

                    <div class="flex flex-wrap gap-2 text-xs font-medium">
                        @foreach ($anime['genres'] as $genre)
                            <span class="rounded-full bg-slate-800/80 px-3 py-1 text-slate-300">{{ $genre }}</span>
                        @endforeach
                    </div>

                    <x-slot name="footer">
                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                {{ count($anime['voice_actors']) }} voice actors
                            </div>
                            <span class="text-slate-600">•</span>
                            <span class="transition group-hover:text-sky-300">View characters →</span>
                        </div>
                    </x-slot>
                </x-resource-card>
            @endforeach
        </div>
    </div>
@endsection
