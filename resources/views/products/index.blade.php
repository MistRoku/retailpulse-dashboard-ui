@extends('layouts.app')

@section('title', 'Products | RetailPulse')

@section('content')
    {{-- 
      COLOR PALETTE REFERENCE FOR THIS FILE:
      -- Primary Ink: #2C3E30
      -- Muted Text: #4A5D50
      -- Border Light: #8DA399
      -- Border Dark: #2C3E30
      -- Accent Sage: #A8D8B9
      -- Warm Sand: #F3E9D7
      -- Pale Gold: #EAE2B7
      -- Clay Danger: #C47A65
    --}}

    <div
        x-data="productCatalog(@js($products))"
        x-init="init()"
    >
        <x-section-header
            title="Product Catalog"
            description="Manage inventory across all branches."
        />

        {{-- FILTER TOOLBAR --}}
        <section aria-labelledby="filters-heading" class="mt-6 border border-[#8DA399] bg-white p-4">
            <h2 id="filters-heading" class="sr-only">Product filters</h2>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="product-search" class="mb-1 block text-sm font-medium text-[#2C3E30]">Search</label>
                    <input
                        id="product-search"
                        type="search"
                        x-model.debounce.300ms="query"
                        class="w-full border border-[#8DA399] bg-white px-3 py-2 text-sm text-[#2C3E30] placeholder-[#8DA399] focus:border-[#2C3E30] focus:outline-none rounded-none shadow-none"
                        placeholder="Name or SKU"
                    >
                </div>

                <div>
                    <label for="product-category" class="mb-1 block text-sm font-medium text-[#2C3E30]">Category</label>
                    <select id="product-category" x-model="category" class="w-full border border-[#8DA399] bg-white px-3 py-2 text-sm text-[#2C3E30] focus:border-[#2C3E30] focus:outline-none rounded-none shadow-none appearance-none">
                        @foreach ($categories as $categoryItem)
                            <option value="{{ $categoryItem }}">{{ $categoryItem }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="product-sort" class="mb-1 block text-sm font-medium text-[#2C3E30]">Sort By</label>
                    <select id="product-sort" x-model="sort" class="w-full border border-[#8DA399] bg-white px-3 py-2 text-sm text-[#2C3E30] focus:border-[#2C3E30] focus:outline-none rounded-none shadow-none appearance-none">
                        <option value="name-asc">Name, A-Z</option>
                        <option value="name-desc">Name, Z-A</option>
                        <option value="price-asc">Price, Low-High</option>
                        <option value="price-desc">Price, High-Low</option>
                        <option value="stock-asc">Stock, Low-High</option>
                        <option value="stock-desc">Stock, High-Low</option>
                        <option value="date-desc">Newest First</option>
                    </select>
                </div>

                <div>
                    <span class="mb-1 block text-sm font-medium text-[#2C3E30]">View Mode</span>
                    <div class="flex gap-2">
                        <button
                            type="button"
                            @click="view = 'list'"
                            :class="view === 'list' ? 'bg-[#2C3E30] text-white border-[#2C3E30]' : 'bg-white text-[#2C3E30] border-[#8DA399]'"
                            class="flex-1 border px-3 py-2 text-sm font-medium transition-none rounded-none shadow-none cursor-pointer"
                        >
                            List
                        </button>
                        <button
                            type="button"
                            @click="view = 'grid'"
                            :class="view === 'grid' ? 'bg-[#2C3E30] text-white border-[#2C3E30]' : 'bg-white text-[#2C3E30] border-[#8DA399]'"
                            class="flex-1 border px-3 py-2 text-sm font-medium transition-none rounded-none shadow-none cursor-pointer"
                        >
                            Grid
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- RESULTS HEADER --}}
        <div class="mt-6 flex items-center justify-between gap-4">
            <p class="text-sm text-[#4A5D50]">
                Showing <span class="font-semibold text-[#2C3E30]" x-text="filtered().length"></span> products
            </p>
            <p class="text-sm text-[#4A5D50]">
                Page <span class="font-semibold text-[#2C3E30]" x-text="page"></span> of <span class="font-semibold text-[#2C3E30]" x-text="pages()"></span>
            </p>
        </div>

        {{-- SKELETON LOADER --}}
        <div x-show="loading" class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @for ($i = 0; $i < 6; $i++)
                <div class="border border-[#8DA399] bg-white p-4 animate-pulse">
                    <div class="h-4 w-3/4 bg-[#EAE2B7] mb-2"></div>
                    <div class="h-3 w-1/2 bg-[#F3E9D7] mb-4"></div>
                    <div class="h-24 w-full bg-[#F3E9D7]"></div>
                </div>
            @endfor
        </div>

        {{-- EMPTY STATE --}}
        <div x-show="!loading && filtered().length === 0" class="mt-6 border border-[#8DA399] bg-white p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-[#8DA399]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-base font-semibold text-[#2C3E30]">No products found</h3>
            <p class="mt-1 text-sm text-[#4A5D50]">Try adjusting your search or filters.</p>
            <button type="button" @click="resetFilters()" class="mt-4 inline-flex items-center border border-[#2C3E30] bg-white px-4 py-2 text-sm font-medium text-[#2C3E30] hover:bg-[#F3E9D7] transition-none rounded-none shadow-none cursor-pointer">
                Reset Filters
            </button>
        </div>

        {{-- CONTENT AREA --}}
        <div x-show="!loading && filtered().length > 0" class="mt-6">
            
            {{-- LIST VIEW --}}
            <div x-show="view === 'list'" class="overflow-x-auto border border-[#8DA399] bg-white">
                <table class="min-w-full divide-y divide-[#E5E7EB]">
                    <thead class="bg-[#F3E9D7]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">SKU</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">Stock</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#2C3E30]">Added</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] bg-white">
                        <template x-for="product in paginated()" :key="product.id">
                            <tr class="hover:bg-[#FAFAFA] transition-none">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        {{-- Placeholder Image Box --}}
                                        <div class="h-10 w-10 shrink-0 border border-[#8DA399] bg-[#F3E9D7] flex items-center justify-center text-xs font-bold text-[#2C3E30]">
                                            <span x-text="product.initials"></span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-[#2C3E30] truncate" x-text="product.name"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[#4A5D50]" x-text="product.sku"></td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{-- Dynamic Badge using Raw HTML to avoid Blade/Alpine conflict --}}
                                    <span 
                                        class="inline-flex items-center border px-2.5 py-0.5 text-xs font-medium rounded-none shadow-none"
                                        x-bind:class="
                                            product.category === 'Apparel' ? 'border-[#A8D8B9] bg-[#F0FFF4] text-[#2C3E30]' :
                                            product.category === 'Footwear' ? 'border-[#EAE2B7] bg-[#FEFCE8] text-[#2C3E30]' :
                                            'border-[#8DA399] bg-[#F3F4F6] text-[#4A5D50]'
                                        "
                                        x-text="product.category"
                                    ></span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-[#2C3E30]" x-text="formatCurrency(product.price)"></td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    {{-- Stock Indicator --}}
                                    <span 
                                        class="inline-flex items-center gap-1.5"
                                        x-bind:class="
                                            product.stock === 0 ? 'text-[#C47A65]' : 
                                            (product.stock < 10 ? 'text-[#D97706]' : 'text-[#2C3E30]')
                                        "
                                    >
                                        <span class="h-2 w-2 rounded-full" x-bind:class="
                                            product.stock === 0 ? 'bg-[#C47A65]' : 
                                            (product.stock < 10 ? 'bg-[#D97706]' : 'bg-[#A8D8B9]')
                                        "></span>
                                        <span x-text="stockLabel(product.stock)"></span>
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-[#4A5D50]" x-text="product.added"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- GRID VIEW --}}
            <div x-show="view === 'grid'" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <template x-for="product in paginated()" :key="product.id">
                    <article class="group relative border border-[#8DA399] bg-white p-4 flex flex-col hover:border-[#2C3E30] transition-none">
                        
                        {{-- Image Area --}}
                        <div class="aspect-square w-full overflow-hidden border border-[#E5E7EB] bg-[#F3E9D7] flex items-center justify-center mb-4">
                             <span class="text-2xl font-bold text-[#2C3E30] opacity-20" x-text="product.initials"></span>
                        </div>

                        {{-- Details --}}
                        <h3 class="text-base font-semibold text-[#2C3E30] line-clamp-2" x-text="product.name"></h3>
                        <p class="mt-1 text-xs text-[#4A5D50]" x-text="product.sku"></p>

                        <div class="mt-3 flex items-center justify-between">
                            <p class="text-lg font-bold text-[#2C3E30]" x-text="formatCurrency(product.price)"></p>
                            
                            {{-- Stock Pill --}}
                            <span 
                                class="inline-flex items-center px-2 py-1 text-xs font-medium border rounded-none shadow-none"
                                x-bind:class="
                                    product.stock === 0 ? 'border-[#C47A65] text-[#C47A65] bg-red-50' : 
                                    (product.stock < 10 ? 'border-[#D97706] text-[#D97706] bg-yellow-50' : 'border-[#A8D8B9] text-[#2C3E30] bg-green-50')
                                "
                                x-text="product.stock + ' left'"
                            ></span>
                        </div>

                        {{-- Action Button --}}
                        <button 
                            type="button" 
                            class="mt-4 w-full border border-[#2C3E30] bg-white py-2 text-sm font-medium text-[#2C3E30] hover:bg-[#2C3E30] hover:text-white transition-none rounded-none shadow-none cursor-pointer"
                        >
                            View Details
                        </button>
                    </article>
                </template>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8 flex items-center justify-between border-t border-[#E5E7EB] pt-4">
            <div class="flex-1 flex justify-between sm:hidden">
                <button @click="prevPage()" :disabled="page === 1" class="relative inline-flex items-center px-4 py-2 border border-[#8DA399] text-sm font-medium text-[#2C3E30] bg-white hover:bg-[#F3E9D7] disabled:opacity-50 disabled:cursor-not-allowed rounded-none shadow-none cursor-pointer">
                    Previous
                </button>
                <button @click="nextPage()" :disabled="page >= pages()" class="ml-3 relative inline-flex items-center px-4 py-2 border border-[#8DA399] text-sm font-medium text-[#2C3E30] bg-white hover:bg-[#F3E9D7] disabled:opacity-50 disabled:cursor-not-allowed rounded-none shadow-none cursor-pointer">
                    Next
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
                <nav class="relative z-0 inline-flex -space-x-px rounded-none shadow-sm" aria-label="Pagination">
                    <button @click="prevPage()" :disabled="page === 1" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#2C3E30] bg-white border border-[#8DA399] hover:bg-[#F3E9D7] disabled:opacity-50 rounded-none cursor-pointer mr-2">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </button>
                    
                    <template x-for="pageNumber in pagesArray()" :key="pageNumber">
                        <button 
                            @click="page = pageNumber"
                            x-bind:class="pageNumber === page ? 'bg-[#2C3E30] text-white border-[#2C3E30]' : 'bg-white text-[#2C3E30] border-[#8DA399] hover:bg-[#F3E9D7]'"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium border rounded-none cursor-pointer mx-1 min-w-[2.5rem]"
                            x-text="pageNumber"
                        ></button>
                    </template>

                    <button @click="nextPage()" :disabled="page >= pages()" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#2C3E30] bg-white border border-[#8DA399] hover:bg-[#F3E9D7] disabled:opacity-50 rounded-none cursor-pointer ml-2">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>
@endsection