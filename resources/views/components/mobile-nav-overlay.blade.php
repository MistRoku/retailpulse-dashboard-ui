<div
    x-show="mobileNavOpen"
    x-cloak
    class="fixed inset-0 z-50 bg-white lg:hidden"
    x-trap.noscroll="mobileNavOpen"
    @keydown.escape.window="closeMobileNav"
    role="dialog"
    aria-modal="true"
    aria-label="Mobile navigation"
>
    <div class="flex h-16 items-center justify-between border-b border-gray-300 px-4">
        <span class="text-base font-semibold text-gray-900">RetailPulse</span>

        <button type="button" @click="closeMobileNav" class="rp-button px-3 py-2" aria-label="Close navigation">
            <i data-lucide="x" class="h-5 w-5" aria-hidden="true"></i>
        </button>
    </div>

    <nav class="p-4">
        <ul class="space-y-3">
            <li><a href="{{ route('dashboard') }}" class="rp-link block py-2 text-base">Dashboard</a></li>
            <li><a href="{{ route('products.index') }}" class="rp-link block py-2 text-base">Products</a></li>
            <li><a href="{{ route('staff.index') }}" class="rp-link block py-2 text-base">Staff</a></li>
            <li><a href="{{ route('pos.terminal') }}" class="rp-link block py-2 text-base">Point of Sale</a></li>
            <li><a href="{{ route('reports.index') }}" class="rp-link block py-2 text-base">Reports</a></li>
            <li><a href="{{ route('settings.index') }}" class="rp-link block py-2 text-base">Settings</a></li>
            <li><a href="{{ route('legal.terms') }}" class="rp-link block py-2 text-base">Terms of Service</a></li>
            <li><a href="{{ route('legal.privacy') }}" class="rp-link block py-2 text-base">Privacy Policy</a></li>
        </ul>
    </nav>
</div>
