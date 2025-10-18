@props([
    'href',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-2 text-sm font-medium text-sky-300 transition hover:text-sky-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-300',
    ]) }}
>
    <svg
        class="h-4 w-4 -ml-1"
        viewBox="0 0 20 20"
        fill="currentColor"
        aria-hidden="true"
    >
        <path fill-rule="evenodd" d="M9.707 3.293a1 1 0 0 1 0 1.414L5.414 9H17a1 1 0 1 1 0 2H5.414l4.293 4.293a1 1 0 0 1-1.414 1.414l-6-6a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
    </svg>
    <span>{{ $slot }}</span>
</a>
