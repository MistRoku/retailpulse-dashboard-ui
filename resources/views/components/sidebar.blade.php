@php
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard'],
        ['label' => 'Products', 'route' => 'products.index', 'icon' => 'package'],
        ['label' => 'Staff', 'route' => 'staff.index', 'icon' => 'users'],
        ['label' => 'Point of Sale', 'route' => 'pos.terminal', 'icon' => 'shopping-cart'],
        ['label' => 'Reports', 'route' => 'reports.index', 'icon' => 'file-text'],
        ['label' => 'Settings', 'route' => 'settings.index', 'icon' => 'settings'],
    ];
@endphp

<aside
    x-show="mobileNavOpen"
    x-cloak
    @keydown.escape.window="closeMobileNav()"
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-gray-300 bg-white lg:hidden"
    role="navigation"
    aria-label="Mobile navigation"
>
    <div class="flex h-16 items-center justify-between border-b border-gray-300 px-4">
        <span class="text-base font-semibold text-gray-900">RetailPulse</span>

        <button
            type="button"
            @click="closeMobileNav()"
            class="rp-button px-2 py-1"
            aria-label="Close navigation"
        >
            <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto p-3">
        <ul class="space-y-2">
            @foreach ($navigation as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp

                <li>
                    <a
                        href="{{ route($item['route']) }}"
                        @click="closeMobileNav()"
                        @class([
                            'flex items-center gap-3 border px-3 py-2 text-sm',
                            'border-gray-900 font-semibold text-gray-900' => $isActive,
                            'border-gray-200 text-gray-700' => !$isActive,
                        ])
                    >
                        <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0" aria-hidden="true"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-gray-300 p-3">
        <a href="{{ route('legal.terms') }}" class="block px-3 py-2 text-sm text-gray-700">Terms of Service</a>
        <a href="{{ route('legal.privacy') }}" class="block px-3 py-2 text-sm text-gray-700">Privacy Policy</a>
    </div>
</aside>

<div
    x-show="mobileNavOpen"
    x-cloak
    @click="closeMobileNav()"
    class="fixed inset-0 z-40 bg-black/40 lg:hidden"
    aria-hidden="true"
></div>
