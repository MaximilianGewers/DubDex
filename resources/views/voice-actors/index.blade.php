@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <div class="max-w-3xl">
            <x-back-link :href="route('animes.index')">
                Browse animes
            </x-back-link>
            <h1 class="mt-4 text-4xl font-bold tracking-tight text-white">Voice Actor Directory</h1>
            <p class="mt-3 text-lg text-slate-300">
                Discover the multilingual talent voicing your favourite characters. Each profile shows the characters they portray
                and the anime productions they appear in.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($voiceActors as $voiceActor)
                <x-resource-card :href="route('voice-actors.show', $voiceActor['id'])">
                    <x-slot name="header">
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="text-2xl font-semibold text-white transition group-hover:text-sky-300">{{ $voiceActor['name'] }}</h2>
                            <span class="rounded-full bg-sky-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-300">
                                {{ $voiceActor['anime_count'] }} Anime
                            </span>
                        </div>
                        <p class="text-sm uppercase tracking-wide text-slate-400">{{ $voiceActor['language'] }} Voice</p>
                    </x-slot>

                    <p class="text-sm text-slate-300">{{ $voiceActor['description'] }}</p>

                    <x-slot name="footer">
                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                {{ $voiceActor['character_count'] }} characters
                            </div>
                            <span class="text-slate-600">•</span>
                            <span class="transition group-hover:text-sky-300">View profile →</span>
                        </div>
                    </x-slot>
                </x-resource-card>
            @endforeach
        </div>
    </div>
@endsection
