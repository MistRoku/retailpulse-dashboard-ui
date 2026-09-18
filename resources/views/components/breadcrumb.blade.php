@if (!empty($items))
    <nav aria-label="Breadcrumb" class="text-sm">
        <ol class="flex flex-wrap items-center gap-2 text-gray-700">
            @foreach ($items as $index => $item)
                <li class="flex items-center gap-2">
                    @if ($index > 0)
                        <span aria-hidden="true" class="text-gray-500">/</span>
                    @endif

                    @if ($loop->last)
                        <span class="font-semibold text-gray-900">{{ $item['label'] }}</span>
                    @else
                        <a href="{{ $item['url'] }}" class="rp-link">{{ $item['label'] }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
