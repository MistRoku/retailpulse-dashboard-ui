@props([
    'checked' => false,
    'label' => '',
])

<button
    type="button"
    role="switch"
    aria-checked="{{ $checked ? 'true' : 'false' }}"
    @if($label) aria-label="{{ $label }}" @else aria-label="Toggle setting" @endif
    {{ $attributes->merge(['class' => 'relative h-6 w-12 border border-gray-500 bg-white cursor-pointer focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2']) }}
>
    <span
        @class([
            'absolute top-1 h-4 w-4 bg-gray-900',
            'left-7' => $checked,
            'left-1' => !$checked,
        ])
    ></span>
</button>
