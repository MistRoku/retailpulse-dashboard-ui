@php
    $currentRoute = request()->route();
@endphp

<header
    x-data
    class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-4 border-b border-gray-300 bg-white px-4 lg:px-6"
    role="banner"
>
    <button
        type="button"
        @click="toggleMobileNav()"
        class="rp-button rp-button-quiet px-2 py-1 lg:hidden"
        aria-label="Open navigation menu"
    >
        <i data-lucide="menu" class="h-5 w-5" aria-hidden="true"></i>
    </button>

    <span class="text-base font-semibold text-gray-900 lg:hidden">RetailPulse</span>

    <div class="hidden flex-1 lg:block"></div>

    <button
        type="button"
        @click="globalSearchOpen = true"
        class="rp-button rp-button-quiet px-2 py-1"
        aria-label="Open search"
    >
        <i data-lucide="search" class="h-5 w-5" aria-hidden="true"></i>
    </button>

    <button
        type="button"
        @click="toggleContrast()"
        class="rp-button rp-button-quiet px-2 py-1"
        :aria-pressed="contrastHigh.toString()"
        aria-label="Toggle high contrast mode"
    >
        <i data-lucide="eye" class="h-5 w-5" aria-hidden="true"></i>
    </button>

    <div class="relative" @keydown.escape="notificationsOpen = false">
        <button
            type="button"
            @click="toggleNotifications()"
            class="rp-button rp-button-quiet px-2 py-1"
            :aria-expanded="notificationsOpen.toString()"
            aria-label="Notifications"
            aria-haspopup="true"
        >
            <span class="relative">
                <i data-lucide="bell" class="h-5 w-5" aria-hidden="true"></i>
                <span
                    x-show="unreadCount > 0"
                    x-text="unreadCount"
                    class="absolute -right-1.5 -top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-gray-900 text-[10px] font-bold text-white"
                ></span>
            </span>
        </button>

        <div
            x-show="notificationsOpen"
            x-cloak
            @click.outside="notificationsOpen = false"
            class="absolute right-0 top-full mt-2 w-72 border border-gray-300 bg-white p-3"
            role="menu"
            aria-label="Notifications"
        >
            <p class="text-sm font-semibold text-gray-900">Notifications</p>
            <p class="mt-2 text-sm text-gray-700">No unread notifications.</p>
        </div>
    </div>

    <div class="relative" @keydown.escape="userMenuOpen = false">
        <button
            type="button"
            @click="toggleUserMenu()"
            class="rp-button rp-button-quiet px-2 py-1"
            :aria-expanded="userMenuOpen.toString()"
            aria-label="User menu"
            aria-haspopup="true"
        >
            <i data-lucide="user" class="h-5 w-5" aria-hidden="true"></i>
        </button>

        <div
            x-show="userMenuOpen"
            x-cloak
            @click.outside="userMenuOpen = false"
            class="absolute right-0 top-full mt-2 w-48 border border-gray-300 bg-white"
            role="menu"
            aria-label="User menu"
        >
            <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">Settings</a>
            <a href="{{ route('legal.terms') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">Terms of Service</a>
            <a href="{{ route('legal.privacy') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">Privacy Policy</a>
        </div>
    </div>

    <div
        x-show="globalSearchOpen"
        x-cloak
        @keydown.escape.window="globalSearchOpen = false"
        class="fixed inset-0 z-50 bg-black/40"
        @click.self="globalSearchOpen = false"
        role="dialog"
        aria-modal="true"
        aria-label="Global search"
    >
        <div class="mx-auto mt-24 w-full max-w-lg border border-gray-300 bg-white p-4">
            <div class="flex items-center gap-3">
                <i data-lucide="search" class="h-5 w-5 text-gray-500" aria-hidden="true"></i>
                <input
                    type="search"
                    x-model.debounce.300ms="searchQuery"
                    x-init="$watch('globalSearchOpen', v => { if (v) $nextTick(() => $el.focus()) })"
                    class="rp-field flex-1"
                    placeholder="Search products, staff, reports…"
                    aria-label="Search the application"
                    @input="runSearch()"
                >
                <button type="button" @click="globalSearchOpen = false" class="rp-button px-2 py-1" aria-label="Close search">
                    <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
                </button>
            </div>

            <ul x-show="searchResults.length > 0" class="mt-3 divide-y divide-gray-200" role="listbox" aria-label="Search results">
                <template x-for="result in searchResults" :key="result.label">
                    <li>
                        <a
                            :href="result.url"
                            class="flex items-center justify-between px-2 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            role="option"
                        >
                            <span x-text="result.label"></span>
                            <span class="text-xs text-gray-500" x-text="result.type"></span>
                        </a>
                    </li>
                </template>
            </ul>

            <p
                x-show="searchQuery.length > 0 && searchResults.length === 0 && !searching"
                class="mt-3 text-sm text-gray-500"
            >No results found.</p>
        </div>
    </div>
</header>
