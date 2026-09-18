@props([
    'title',
    'description' => '',
])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>

    @if ($description)
        <p class="mt-1 text-sm text-gray-700">{{ $description }}</p>
    @endif
</div>
