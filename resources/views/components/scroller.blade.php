@props([
    'label' => '',
])

<div
    {{ $attributes->merge(['class' => 'rp-scroll-row']) }}
    @if($label) aria-label="{{ $label }}" @endif
    role="list"
>
    {{ $slot }}
</div>
