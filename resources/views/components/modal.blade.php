@props([
    'name' => 'modal',
    'title' => '',
    'maxWidth' => 'max-w-xl',
])

<div
    x-show="{{ $name }}"
    x-cloak
    class="fixed inset-0 z-50 bg-white"
    role="dialog"
    aria-modal="true"
    @if($title) aria-label="{{ $title }}" @endif
    @keydown.escape.window="{{ $name }} = false"
>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="w-full {{ $maxWidth }} border border-gray-900 bg-white">
            <div class="flex items-center justify-between border-b border-gray-300 px-5 py-4">
                <h2 class="text-base font-semibold text-gray-900">{{ $title }}</h2>

                <button
                    type="button"
                    @click="{{ $name }} = false"
                    class="rp-button px-2 py-1"
                    aria-label="Close dialog"
                >
                    <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
                </button>
            </div>

            <div class="px-5 py-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="border-t border-gray-300 px-5 py-4">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
