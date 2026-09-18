@props([
    'type' => 'line',
    'width' => 'w-full',
    'height' => 'h-4',
])

<div
    {{ $attributes->merge(['class' => 'border border-dashed border-gray-400 bg-white p-2']) }}
    aria-hidden="true"
>
    @if ($type === 'card')
        <div class="h-3 w-20 border-b border-gray-500"></div>
        <div class="mt-4 h-7 w-32 border-b border-gray-900"></div>
        <div class="mt-4 h-3 w-full border-b border-gray-400"></div>
        <div class="mt-2 h-3 w-2/3 border-b border-gray-400"></div>
    @elseif ($type === 'chart')
        <div class="flex h-48 items-end gap-2">
            <div class="h-16 w-6 border border-gray-400 bg-white"></div>
            <div class="h-24 w-6 border border-gray-400 bg-white"></div>
            <div class="h-12 w-6 border border-gray-400 bg-white"></div>
            <div class="h-28 w-6 border border-gray-400 bg-white"></div>
            <div class="h-20 w-6 border border-gray-400 bg-white"></div>
            <div class="h-10 w-6 border border-gray-400 bg-white"></div>
            <div class="h-24 w-6 border border-gray-400 bg-white"></div>
        </div>
    @elseif ($type === 'row')
        <div class="flex gap-3">
            <div class="h-4 w-1/4 border-b border-gray-500"></div>
            <div class="h-4 w-1/4 border-b border-gray-400"></div>
            <div class="h-4 w-1/6 border-b border-gray-400"></div>
            <div class="h-4 w-1/6 border-b border-gray-400"></div>
        </div>
    @else
        <div class="{{ $height }} {{ $width }} border-b border-gray-500"></div>
    @endif
</div>
