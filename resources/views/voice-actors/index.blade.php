@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <div class="max-w-3xl">
            <a href="{{ route('animes.index') }}" class="text-sm font-medium text-sky-300 transition hover:text-sky-200">← Browse animes</a>
            <h1 class="mt-4 text-4xl font-bold tracking-tight text-white">Voice Actor Directory</h1>
            <p class="mt-3 text-lg text-slate-300">
                Discover the multilingual talent voicing your favourite characters. Each profile shows the characters they portray
                and the anime productions they appear in.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($voiceActors as $voiceActor)
                <x-resource-card>
                    <x-slot name="header">
                        <div>
                            <a href="{{ route('voice-actors.show', $voiceActor['id']) }}" class="text-2xl font-semibold text-white transition hover:text-sky-300">{{ $voiceActor['name'] }}</a>
                            <p class="text-sm uppercase tracking-wide text-slate-400">{{ $voiceActor['language'] }} Voice</p>
                        </div>
                    </x-slot>

                    <div class="flex gap-4 text-xs text-slate-400">
                        <span class="rounded-full bg-slate-800 px-3 py-1 font-medium text-slate-200">{{ $voiceActor['anime_count'] }} anime</span>
                        <span class="rounded-full bg-slate-800 px-3 py-1 font-medium text-slate-200">{{ $voiceActor['character_count'] }} characters</span>
                    </div>

                    <div class="space-y-3">
                        @foreach ($voiceActor['roles'] as $role)
                            <div class="rounded-xl bg-slate-950/60 p-4">
                                <p class="text-sm font-semibold text-white">{{ $role['character_name'] }}</p>
                                <p class="text-xs text-slate-400">{{ $role['character_role'] }}</p>
                                <a href="{{ route('animes.show', $role['anime_id']) }}" class="mt-2 inline-flex text-xs font-medium text-sky-300 transition hover:text-sky-200">
                                    Appears in {{ $role['anime_title'] }} →
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <x-slot name="footer">
                        <a href="{{ route('voice-actors.show', $voiceActor['id']) }}" class="inline-flex text-sm font-semibold text-sky-300 transition hover:text-sky-200">View full profile →</a>
                    </x-slot>
                </x-resource-card>
            @endforeach
        </div>
    </div>
@endsection
