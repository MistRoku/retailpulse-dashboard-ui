@props([
    'currentPage' => 1,
    'lastPage' => 1,
])

<nav aria-label="Pagination" class="flex flex-wrap items-center gap-2">
    <button type="button" class="rp-button rp-button-quiet" @if($currentPage <= 1) disabled @endif>
        Previous
    </button>

    @for ($page = 1; $page <= $lastPage; $page++)
        <button
            type="button"
            @class([
                'rp-button',
                'rp-button-primary' => $page === $currentPage,
                'rp-button-quiet' => $page !== $currentPage,
            ])
            aria-current="{{ $page === $currentPage ? 'page' : 'false' }}"
        >
            {{ $page }}
        </button>
    @endfor

    <button type="button" class="rp-button rp-button-quiet" @if($currentPage >= $lastPage) disabled @endif>
        Next
    </button>
</nav>
