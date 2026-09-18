@props([
    'title' => 'No results found',
    'description' => 'Adjust your filters and try again.',
])

<div {{ $attributes->merge(['class' => 'border border-gray-300 bg-white p-8 text-center']) }}>
    <svg
        class="mx-auto h-16 w-16 text-gray-500"
        viewBox="0 0 64 64"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        aria-hidden="true"
    >
        <rect x="10" y="18" width="44" height="32" />
        <path d="M10 28h44" />
        <path d="M24 18v-6h16v6" />
        <path d="M22 40h20" />
        <path d="M26 46h12" />
    </svg>

    <h3 class="mt-5 text-base font-semibold text-gray-900">{{ $title }}</h3>
    <p class="mt-2 text-sm text-gray-700">{{ $description }}</p>

    @isset($action)
        <div class="mt-5">
            {{ $action }}
        </div>
    @endisset
</div>
