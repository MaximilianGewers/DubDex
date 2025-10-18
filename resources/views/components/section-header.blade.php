@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->class('space-y-4') }}>
    <div>
        <h1 class="text-4xl font-bold tracking-tight text-white">{{ $title }}</h1>
        @if (filled($subtitle))
            <p class="mt-3 max-w-3xl text-lg text-slate-300">{{ $subtitle }}</p>
        @endif
    </div>

    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>
