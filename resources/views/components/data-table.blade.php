@props([
    'caption' => '',
])

<div class="overflow-x-auto border border-gray-300 bg-white">
    <table class="rp-table">
        @if($caption)
            <caption class="sr-only">{{ $caption }}</caption>
        @endif

        {{ $slot }}
    </table>
</div>
