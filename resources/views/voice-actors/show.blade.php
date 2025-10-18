@extends('layouts.app')

@section('content')
    <div class="space-y-12">
        <div class="space-y-6">
            <x-back-link :href="route('voice-actors.index')">
                Back to voice actor directory
            </x-back-link>
            <div class="space-y-4">
                <div>
                    <h1 class="text-4xl font-bold tracking-tight text-white">{{ $voiceActor['name'] }}</h1>
                    <p class="mt-3 max-w-3xl text-lg text-slate-300">
                        Explore the characters and anime credits voiced by {{ $voiceActor['name'] }}.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="rounded-full bg-slate-800 px-3 py-1 uppercase tracking-wide text-slate-200">{{ $voiceActor['language'] }}
                        Voice</span>
                    <span class="rounded-full bg-slate-800 px-3 py-1 uppercase tracking-wide text-slate-200">{{ $voiceActor['anime_count'] }}
                        Anime Credits</span>
                    <span class="rounded-full bg-slate-800 px-3 py-1 uppercase tracking-wide text-slate-200">{{ $voiceActor['character_count'] }}
                        Characters</span>
                </div>
            </div>
        </div>

        @if (count($voiceActor['animes']) > 0)
            <section class="space-y-4">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Anime Credits</h2>
                    <p class="text-sm text-slate-400">Series featuring performances from {{ $voiceActor['name'] }}.</p>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($voiceActor['animes'] as $anime)
                        <a href="{{ route('animes.show', $anime['id']) }}"
                            class="block rounded-xl border border-slate-800 bg-slate-900/60 p-4 transition hover:border-sky-500/60 hover:bg-slate-900">
                            <h3 class="text-lg font-semibold text-white">{{ $anime['title'] }}</h3>
                            <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">Featured Role</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if (count($voiceActor['roles']) > 0)
            <section class="space-y-4">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Characters Voiced</h2>
                    <p class="text-sm text-slate-400">Discover the characters brought to life by {{ $voiceActor['name'] }}.</p>
                </div>
                <div class="space-y-4">
                    @foreach ($voiceActor['roles'] as $role)
                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-6">
                            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-white">{{ $role['name'] }}</h3>
                                    <p class="mt-2 text-sm text-slate-300">{{ $role['role'] }}</p>
                                </div>
                                @if (!empty($role['anime']['id']))
                                    <a href="{{ route('animes.show', $role['anime']['id']) }}"
                                        class="inline-flex items-center text-sm font-medium text-sky-300 transition hover:text-sky-200">
                                        Appears in {{ $role['anime']['title'] }} →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
