<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-10">
        <div class="space-y-2">
            <h1 class="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ __('Manage the anime library') }}
            </h1>
            <p class="max-w-2xl text-sm text-zinc-600 dark:text-zinc-300">
                {{ __('Add new anime series and review the ones already in DubDex without leaving the dashboard.') }}
            </p>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,420px)_1fr]">
            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ __('Add a new anime') }}
                </h2>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __('Provide the core details and we will generate the slug automatically.') }}
                </p>

                @if (session('status'))
                    <div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.animes.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <flux:input
                        name="title"
                        :label="__('Title')"
                        placeholder="{{ __('e.g. Fullmetal Alchemist: Brotherhood') }}"
                        value="{{ old('title') }}"
                        required
                        autocomplete="off"
                    />

                    <flux:textarea
                        name="synopsis"
                        :label="__('Synopsis')"
                        rows="5"
                        required
                    >{{ old('synopsis') }}</flux:textarea>

                    <flux:input
                        name="genres"
                        :label="__('Genres')"
                        placeholder="{{ __('Action, Adventure, Fantasy') }}"
                        value="{{ old('genres') }}"
                        description="{{ __('Separate each genre with a comma.') }}"
                    />

                    <flux:button type="submit" variant="primary" class="w-full justify-center">
                        {{ __('Save anime') }}
                    </flux:button>
                </form>
            </div>

            <div class="space-y-4">
                @php
                    $animeCount = $animes->count();
                    $animeSummary = trans_choice('[0]No animes yet|[1]1 anime|[2,*]:count animes', $animeCount, ['count' => $animeCount]);
                @endphp

                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        {{ __('Recent animes') }}
                    </h2>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $animeSummary }}
                    </span>
                </div>

                @if ($animes->isEmpty())
                    <div class="rounded-2xl border border-dashed border-zinc-300 bg-white/60 p-10 text-center text-sm text-zinc-500 dark:border-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-300">
                        {{ __('Once you add an anime it will appear here with a quick summary.') }}
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($animes as $anime)
                            <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:border-sky-200 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-sky-500/40">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div class="space-y-1">
                                        <h3 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $anime->title }}</h3>
                                        <span class="inline-flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                            {{ $anime->slug }}
                                        </span>
                                    </div>
                                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                        {{ optional($anime->created_at)->format('M j, Y') }}
                                    </span>
                                </div>

                                <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                                    {{ \Illuminate\Support\Str::limit($anime->synopsis, 220) }}
                                </p>

                                @if (! empty($anime->genres))
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($anime->genres as $genre)
                                            <span class="rounded-full bg-sky-500/10 px-3 py-1 text-xs font-medium text-sky-600 dark:bg-sky-400/10 dark:text-sky-200">
                                                {{ $genre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
