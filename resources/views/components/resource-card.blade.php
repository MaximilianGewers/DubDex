@props([
    'href' => null,
])

@php
    $baseClasses = 'group flex h-full flex-col justify-between rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow transition';

    if ($href) {
        $baseClasses .= ' hover:-translate-y-1 hover:border-sky-400/60 hover:shadow-sky-500/10';
    }
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($baseClasses) }}>
@else
    <div {{ $attributes->class($baseClasses) }}>
@endif
        <div class="space-y-4">
            @isset($header)
                {{ $header }}
            @endisset

            {{ $slot }}
        </div>

        @isset($footer)
            <div class="mt-6">
                {{ $footer }}
            </div>
        @endisset
@if ($href)
    </a>
@else
    </div>
@endif
