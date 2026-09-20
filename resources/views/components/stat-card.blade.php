@props([
    'title',
    'value',
    'change',
    'direction' => 'neutral',
    'comparison' => '',
])

<article {{ $attributes->merge(['class' => 'rp-scroll-item rp-card']) }}>
    <p class="text-sm font-medium text-ink-muted">{{ $title }}</p>

    <p class="mt-3 text-2xl font-bold text-ink">{{ $value }}</p>

    <div class="mt-2 flex items-center gap-2 text-sm">
        {{-- Trend Indicator --}}
        @if ($direction === 'increase')
            <span class="flex items-center gap-1 text-sage font-semibold">
                <svg aria-hidden="true" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                {{ $change }}
            </span>
        @elseif ($direction === 'decrease')
            <span class="flex items-center gap-1 text-clay font-semibold">
                <svg aria-hidden="true" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                {{ $change }}
            </span>
        @else
            <span class="text-ink-faint font-medium">{{ $change }}</span>
        @endif

        {{-- Comparison Text --}}
        @if ($comparison)
            <span class="text-ink-faint">{{ $comparison }}</span>
        @endif
    </div>
</article>
