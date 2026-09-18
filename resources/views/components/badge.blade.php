@props([
    'variant' => 'quiet',
])

@php
    $variants = [
        'strong' => 'border-gray-900 text-gray-900 font-semibold',
        'default' => 'border-gray-500 text-gray-800',
        'quiet' => 'border-gray-300 text-gray-600',
    ];
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center border bg-white px-2 py-1 text-xs ' . ($variants[$variant] ?? $variants['quiet'])]) }}
>
    {{ $slot }}
</span>
