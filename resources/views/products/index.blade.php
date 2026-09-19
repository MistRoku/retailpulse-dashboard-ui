@extends('layouts.app')

@section('title', 'Products | RetailPulse')

@section('content')
    <div
        x-data="productCatalog(@js($products))"
        x-init="init()"
    >
        <x-section-header
            title="Product catalog"
            description="Browse inventory, filter by category, and switch viewing modes."
        />

        <section aria-labelledby="filters-heading" class="mt-6 border border-gray-300 bg-white p-4">
            <h2 id="filters-heading" class="sr-only">Product filters</h2>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="product-search" class="rp-label">Search</label>
                    <input
                        id="product-search"
                        type="search"
                        x-model.debounce.300ms="query"
                        class="rp-field"
                        placeholder="Name or SKU"
                    >
                </div>

                <div>
                    <label for="product-category" class="rp-label">Category</label>
                    <select id="product-category" x-model="category" class="rp-field">
                        @foreach ($categories as $categoryItem)
                            <option value="{{ $categoryItem }}">{{ $categoryItem }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="product-sort" class="rp-label">Sort</label>
                    <select id="product-sort" x-model="sort" class="rp-field">
                        <option value="name-asc">Name, ascending</option>
                        <option value="name-desc">Name, descending</option>
                        <option value="price-asc">Price, low to high</option>
                        <option value="price-desc">Price, high to low</option>
                        <option value="stock-asc">Stock, low to high</option>
                        <option value="stock-desc">Stock, high to low</option>
                        <option value="date-desc">Date added, newest</option>
                        <option value="date-asc">Date added, oldest</option>
                    </select>
                </div>

                <div>
                    <span class="rp-label">View</span>

                    <div class="flex gap-2">
                        <button
                            type="button"
                            @click="view = 'list'"
                            :aria-pressed="view === 'list'"
                            class="rp-button flex-1"
                            x-bind:class="view === 'list' ? 'rp-button-primary' : 'rp-button-quiet'"
                        >
                            List
                        </button>

                        <button
                            type="button"
                            @click="view = 'grid'"
                            :aria-pressed="view === 'grid'"
                            class="rp-button flex-1"
                            x-bind:class="view === 'grid' ? 'rp-button-primary' : 'rp-button-quiet'"
                        >
                            Grid
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="mt-6 flex items-center justify-between gap-4">
            <p class="text-sm text-gray-700">
                <span class="font-semibold text-gray-900" x-text="filtered().length"></span>
                products found
            </p>

            <p class="text-sm text-gray-700">
                Page <span class="font-semibold text-gray-900" x-text="page"></span>
                of <span class="font-semibold text-gray-900" x-text="pages()"></span>
            </p>
        </div>

        <div x-show="loading" class="mt-4 grid gap-4 md:grid-cols-2">
            @for ($i = 0; $i < 6; $i++)
                <x-skeleton type="card" />
            @endfor
        </div>

        <div x-show="!loading && filtered().length === 0" class="mt-6">
            <x-empty-state
                title="No products match your filters"
                description="Clear the search field or choose another category."
            >
                <x-slot:action>
                    <button type="button" @click="resetFilters()" class="rp-button rp-button-primary">
                        Reset filters
                    </button>
                </x-slot:action>
            </x-empty-state>
        </div>

        <div x-show="!loading && filtered().length > 0" class="mt-6">
            <div x-show="view === 'list'" class="border border-gray-300 bg-white">
                <table class="rp-table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Added</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="product in paginated()" :key="product.id">
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-10 w-10 items-center justify-center border border-gray-400 bg-white text-xs font-semibold text-gray-900" x-text="product.initials"></span>
                                        <span class="font-medium text-gray-900" x-text="product.name"></span>
                                    </div>
                                </td>
                                <td x-text="product.sku"></td>
                                <td><x-badge variant="quiet" x-text="product.category"></x-badge></td>
                                <td x-text="formatCurrency(product.price)"></td>
                                <td>
                                    <!--
                                      We use a standard <span> instead of <x-badge> here because
                                      we need dynamic Alpine classes based on 'product.stock'.

                                      Logic:
                                      - stock === 0 -> Strong (Black border/text)
                                      - stock < 10  -> Default (Gray border/text)
                                      - else        -> Quiet (Light gray border/text)
                                    -->
                                    <span
                                        class="inline-flex items-center border bg-white px-2 py-1 text-xs"
                                        x-bind:class="
                                            product.stock === 0
                                                ? 'border-gray-900 text-gray-900 font-semibold'
                                                : (product.stock < 10
                                                    ? 'border-gray-500 text-gray-800'
                                                    : 'border-gray-300 text-gray-600')
                                        "
                                        x-text="stockLabel(product.stock)"
                                    ></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div x-show="view === 'grid'" class="grid gap-4 md:grid-cols-2">
                <template x-for="product in paginated()" :key="product.id">
                    <article class="border border-gray-300 bg-white p-4">
                        <div class="flex aspect-square items-center justify-center border border-gray-300 bg-white text-sm font-semibold text-gray-700" x-text="product.initials"></div>

                        <h3 class="mt-4 text-base font-semibold text-gray-900" x-text="product.name"></h3>
                        <p class="mt-1 text-sm text-gray-700" x-text="product.sku"></p>

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <x-badge variant="quiet" x-text="product.category"></x-badge>
                            <x-badge
                                :variant="product.stock === 0 ? 'strong' : (product.stock < 10 ? 'default' : 'quiet')"
                                x-text="stockLabel(product.stock)"
                            ></x-badge>
                        </div>

                        <p class="mt-4 text-lg font-semibold text-gray-900" x-text="formatCurrency(product.price)"></p>
                    </article>
                </template>
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            <nav aria-label="Product pagination" class="flex flex-wrap items-center gap-2">
                <button type="button" class="rp-button rp-button-quiet" @click="prevPage()" :disabled="page === 1">
                    Previous
                </button>

                <template x-for="pageNumber in pagesArray()" :key="pageNumber">
                    <button
                        type="button"
                        class="rp-button"
                        x-bind:class="pageNumber === page ? 'rp-button-primary' : 'rp-button-quiet'"
                        x-text="pageNumber"
                        @click="page = pageNumber"
                    ></button>
                </template>

                <button type="button" class="rp-button rp-button-quiet" @click="nextPage()" :disabled="page === pages()">
                    Next
                </button>
            </nav>
        </div>
    </div>
@endsection
