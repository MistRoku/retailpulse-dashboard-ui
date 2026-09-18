@extends('layouts.app')

@section('title', 'Point of Sale | RetailPulse')

@section('content')
    <div x-data="posTerminal(@js($products), @js($taxRate), @js($heldOrders))" x-init="init()">
        <x-section-header
            title="Point of sale terminal"
            description="Ring up sales, hold orders, and print receipts."
        />

        <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(20rem,1fr)]">
            <section aria-labelledby="pos-products-heading" class="border border-gray-300 bg-white">
                <div class="border-b border-gray-300 p-4">
                    <h2 id="pos-products-heading" class="text-base font-semibold text-gray-900">Products</h2>

                    <div class="mt-4 grid gap-3 md:grid-cols-[minmax(0,1fr)_auto]">
                        <div>
                            <label for="pos-search" class="sr-only">Search products</label>
                            <input
                                id="pos-search"
                                type="search"
                                x-model.debounce.200ms="query"
                                class="rp-field"
                                placeholder="Search by name or SKU"
                            >
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2 overflow-x-auto pb-1">
                        @foreach ($categories as $category)
                            <button
                                type="button"
                                @click="category = '{{ $category }}'"
                                class="rp-button whitespace-nowrap"
                                x-bind:class="category === '{{ $category }}' ? 'rp-button-primary' : 'rp-button-quiet'"
                            >
                                {{ $category }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div x-show="loading" class="grid gap-4 p-4 md:grid-cols-2">
                    @for ($i = 0; $i < 6; $i++)
                        <x-skeleton type="card" />
                    @endfor
                </div>

                <div x-show="!loading" class="grid gap-4 p-4 md:grid-cols-2">
                    <template x-for="product in filteredProducts()" :key="product.id">
                        <article class="border border-gray-300 bg-white p-4">
                            <div class="flex aspect-square items-center justify-center border border-gray-300 bg-white text-sm font-semibold text-gray-700" x-text="product.initials"></div>

                            <h3 class="mt-3 text-sm font-semibold text-gray-900" x-text="product.name"></h3>
                            <p class="mt-1 text-xs text-gray-600" x-text="product.sku"></p>

                            <div class="mt-3 flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-gray-900" x-text="formatCurrency(product.price)"></p>

                                <button
                                    type="button"
                                    @click="addToCart(product)"
                                    :disabled="product.stock === 0"
                                    class="rp-button rp-button-primary px-3 py-1 text-xs"
                                >
                                    Add
                                </button>
                            </div>
                        </article>
                    </template>

                    <div x-show="filteredProducts().length === 0" class="md:col-span-2">
                        <x-empty-state
                            title="No products found"
                            description="Try another search term or category."
                        />
                    </div>
                </div>
            </section>

            <section aria-labelledby="cart-heading" class="border border-gray-300 bg-white">
                <div class="border-b border-gray-300 p-4">
                    <h2 id="cart-heading" class="text-base font-semibold text-gray-900">Current order</h2>

                    <div class="mt-4 flex gap-2">
                        <button
                            type="button"
                            @click="tab = 'cart'"
                            class="rp-button flex-1"
                            x-bind:class="tab === 'cart' ? 'rp-button-primary' : 'rp-button-quiet'"
                        >
                            Cart
                        </button>

                        <button
                            type="button"
                            @click="tab = 'held'"
                            class="rp-button flex-1"
                            x-bind:class="tab === 'held' ? 'rp-button-primary' : 'rp-button-quiet'"
                        >
                            Held Orders
                        </button>
                    </div>
                </div>

                <div x-show="tab === 'cart'" class="p-4">
                    <div x-show="cart.length === 0" class="border border-dashed border-gray-400 bg-white p-6 text-center text-sm text-gray-700">
                        The cart is empty.
                    </div>

                    <ul x-show="cart.length > 0" class="divide-y divide-gray-200">
                        <template x-for="line in cart" :key="line.id">
                            <li class="py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-900" x-text="line.name"></p>
                                        <p class="mt-1 text-xs text-gray-600" x-text="formatCurrency(line.price) + ' each'"></p>
                                    </div>

                                    <p class="text-sm font-semibold text-gray-900" x-text="formatCurrency(line.price * line.qty)"></p>
                                </div>

                                <div class="mt-3 flex items-center gap-2">
                                    <button type="button" @click="decrement(line)" class="rp-button px-3 py-1" aria-label="Decrease quantity">
                                        -
                                    </button>

                                    <input
                                        type="number"
                                        min="1"
                                        x-model.number="line.qty"
                                        class="rp-field w-16 text-center"
                                        aria-label="Quantity"
                                    >

                                    <button type="button" @click="increment(line)" class="rp-button px-3 py-1" aria-label="Increase quantity">
                                        +
                                    </button>

                                    <button type="button" @click="removeLine(line)" class="rp-button rp-button-quiet ml-auto px-3 py-1 text-xs">
                                        Remove
                                    </button>
                                </div>
                            </li>
                        </template>
                    </ul>

                    <div class="mt-5 border-t border-gray-300 pt-4">
                        <div class="flex items-center justify-between text-sm text-gray-800">
                            <span>Subtotal</span>
                            <span class="font-semibold" x-text="formatCurrency(subtotal)"></span>
                        </div>

                        <div class="mt-3">
                            <label for="discount" class="rp-label">Discount</label>
                            <input id="discount" type="number" min="0" step="0.01" x-model.number="discount" class="rp-field">
                        </div>

                        <div class="mt-3 flex items-center justify-between text-sm text-gray-800">
                            <span>Tax, <span x-text="taxRate"></span>%</span>
                            <span class="font-semibold" x-text="formatCurrency(taxAmount)"></span>
                        </div>

                        <div class="mt-4 flex items-center justify-between border-t border-gray-300 pt-4">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-semibold text-gray-900" x-text="formatCurrency(total)"></span>
                        </div>

                        <fieldset class="mt-5">
                            <legend class="rp-label">Payment method</legend>

                            <div class="grid gap-2">
                                @foreach (['Cash', 'Card', 'E-Wallet'] as $method)
                                    <label class="flex cursor-pointer items-center gap-3 border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900">
                                        <input
                                            type="radio"
                                            name="payment-method"
                                            value="{{ $method }}"
                                            x-model="paymentMethod"
                                            class="h-4 w-4 border border-gray-500 bg-white"
                                        >
                                        <span>{{ $method }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <div class="mt-5 grid gap-2">
                            <button type="button" @click="holdOrder()" class="rp-button">Hold Order</button>
                            <button type="button" @click="completeSale()" :disabled="cart.length === 0" class="rp-button rp-button-primary">
                                Complete Sale
                            </button>
                        </div>
                    </div>
                </div>

                <div x-show="tab === 'held'" class="p-4">
                    <ul x-show="heldOrders.length > 0" class="divide-y divide-gray-200">
                        <template x-for="order in heldOrders" :key="order.id">
                            <li class="py-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900" x-text="order.id"></p>
                                        <p class="mt-1 text-xs text-gray-600" x-text="order.customer"></p>
                                        <p class="mt-1 text-xs text-gray-600" x-text="order.items + ' items'"></p>
                                    </div>

                                    <p class="text-sm font-semibold text-gray-900" x-text="order.total"></p>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <button type="button" @click="resumeOrder(order)" class="rp-button rp-button-primary px-3 py-1 text-xs">
                                        Resume
                                    </button>

                                    <button type="button" @click="dropOrder(order.id)" class="rp-button rp-button-quiet px-3 py-1 text-xs">
                                        Drop
                                    </button>
                                </div>
                            </li>
                        </template>
                    </ul>

                    <div x-show="heldOrders.length === 0" class="border border-dashed border-gray-400 bg-white p-6 text-center text-sm text-gray-700">
                        No held orders.
                    </div>
                </div>
            </section>
        </div>

        <x-modal name="receiptOpen" title="Receipt preview" max-width="max-w-lg">
            <div x-show="lastOrder" class="print-area border border-gray-300 bg-white p-5">
                <div class="text-center">
                    <p class="text-base font-semibold text-gray-900">RetailPulse</p>
                    <p class="mt-1 text-sm text-gray-700">Downtown Flagship</p>
                    <p class="mt-1 text-xs text-gray-600" x-text="'Order ' + lastOrder.reference"></p>
                </div>

                <div class="mt-5 border-t border-gray-300 pt-4">
                    <ul class="divide-y divide-gray-200">
                        <template x-for="line in lastOrder.lines" :key="line.name">
                            <li class="flex items-start justify-between gap-4 py-2 text-sm">
                                <div>
                                    <p class="font-medium text-gray-900" x-text="line.name"></p>
                                    <p class="text-xs text-gray-600" x-text="line.qty + ' x ' + formatCurrency(line.price)"></p>
                                </div>

                                <p class="font-semibold text-gray-900" x-text="formatCurrency(line.qty * line.price)"></p>
                            </li>
                        </template>
                    </ul>
                </div>

                <div class="mt-4 border-t border-gray-300 pt-4 text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span x-text="formatCurrency(lastOrder.subtotal)"></span>
                    </div>

                    <div class="mt-2 flex justify-between">
                        <span>Discount</span>
                        <span x-text="'-' + formatCurrency(lastOrder.discount)"></span>
                    </div>

                    <div class="mt-2 flex justify-between">
                        <span>Tax</span>
                        <span x-text="formatCurrency(lastOrder.tax)"></span>
                    </div>

                    <div class="mt-3 flex justify-between border-t border-gray-300 pt-3 text-base font-semibold">
                        <span>Total</span>
                        <span x-text="formatCurrency(lastOrder.total)"></span>
                    </div>

                    <div class="mt-3 flex justify-between text-gray-700">
                        <span>Payment</span>
                        <span x-text="lastOrder.paymentMethod"></span>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex flex-wrap justify-end gap-3 no-print">
                    <button type="button" @click="receiptOpen = false" class="rp-button rp-button-quiet">Close</button>
                    <button type="button" @click="printReceipt()" class="rp-button">Print</button>
                    <button type="button" @click="newSale()" class="rp-button rp-button-primary">New Sale</button>
                </div>
            </x-slot:footer>
        </x-modal>
    </div>
@endsection
