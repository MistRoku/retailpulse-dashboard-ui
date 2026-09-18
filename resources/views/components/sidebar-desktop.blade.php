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
    x-bind:class="sidebarCollapsed ? 'w-20' : 'w-64'"
    class="sticky top-0 hidden h-screen shrink-0 border-r border-gray-300 bg-white lg:flex lg:flex-col"
    aria-label="Primary navigation"
>
    <div class="flex h-16 items-center justify-between border-b border-gray-300 px-4">
        <span x-show="!sidebarCollapsed" class="text-base font-semibold text-gray-900">
            RetailPulse
        </span>

        <button
            type="button"
            @click="toggleSidebar"
            class="rp-button rp-button-quiet px-2 py-1"
            aria-label="Toggle sidebar"
        >
            <i data-lucide="panel-left" class="h-5 w-5" aria-hidden="true"></i>
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
                        @class([
                            'flex items-center gap-3 border px-3 py-2 text-sm',
                            'border-gray-900 font-semibold text-gray-900' => $isActive,
                            'border-gray-200 text-gray-700' => !$isActive,
                            'justify-center' => true,
                        ])
                        x-bind:class="sidebarCollapsed ? 'justify-center px-2' : 'px-3'"
                    >
                        <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0" aria-hidden="true"></i>
                        <span x-show="!sidebarCollapsed">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-gray-300 p-3">
        <a
            href="{{ route('legal.terms') }}"
            class="block px-3 py-2 text-sm text-gray-700"
            x-show="!sidebarCollapsed"
        >
            Terms of Service
        </a>

        <a
            href="{{ route('legal.privacy') }}"
            class="block px-3 py-2 text-sm text-gray-700"
            x-show="!sidebarCollapsed"
        >
            Privacy Policy
        </a>
    </div>
</aside>
