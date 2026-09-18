@props([
    'open' => 'confirmOpen',
    'title' => 'Confirm action',
    'message' => 'Are you sure?',
    'confirmLabel' => 'Confirm',
    'cancelLabel' => 'Cancel',
])

<x-modal :name="$open" :title="$title">
    <p class="text-sm text-gray-800">{{ $message }}</p>

    <x-slot:footer>
        <div class="flex justify-end gap-3">
            <button type="button" @click="{{ $open }} = false" class="rp-button rp-button-quiet">
                {{ $cancelLabel }}
            </button>

            <button type="button" class="rp-button rp-button-primary">
                {{ $confirmLabel }}
            </button>
        </div>
    </x-slot:footer>
</x-modal>
