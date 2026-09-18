@props([
    'title',
    'value',
    'change',
    'direction' => 'neutral',
    'comparison' => '',
])

<article {{ $attributes->merge(['class' => 'rp-scroll-item border border-gray-300 bg-white p-5']) }}>
    <p class="text-sm font-medium text-gray-700">{{ $title }}</p>

    <p class="mt-3 text-2xl font-semibold text-gray-900">{{ $value }}</p>

    <p class="mt-2 text-sm text-gray-700">
        <span>{{ $direction === 'increase' ? '+' : ($direction === 'decrease' ? '-' : '') }}</span>
        <span class="font-semibold">{{ $change }}</span>
        @if ($comparison)
            <span class="text-gray-600">{{ $comparison }}</span>
        @endif
    </p>
</article>
