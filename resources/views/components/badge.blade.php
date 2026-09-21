@props([
    'variant' => 'info',
])

@php
    $variants = [
        'strong' => 'border-gray-900 text-gray-900 font-semibold',
        'default' => 'border-gray-500 text-gray-800',
        'quiet' => 'border-gray-300 text-gray-600',
        'info' => 'border-gray-300 text-gray-600',
        'success' => 'border-emerald-300 text-emerald-700',
        'warning' => 'border-amber-300 text-amber-700',
        'danger' => 'border-red-300 text-red-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center border bg-white px-2 py-1 text-xs ' . ($variants[$variant] ?? $variants['quiet'])]) }}>
    {{ $slot }}
</span>
