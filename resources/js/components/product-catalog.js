export function productCatalog(items) {
    return {
        loading: true,
        query: '',
        category: 'All',
        sort: 'name-asc',
        view: 'list',
        page: 1,
        perPage: 8,
        items: items.map((item) => ({
            ...item,
            initials: item.name
                .split(' ')
                .slice(0, 2)
                .map((part) => part[0])
                .join('')
                .toUpperCase(),
        })),

        init() {
            window.setTimeout(() => {
                this.loading = false;
            }, 300);

            this.$watch('query', () => {
                this.page = 1;
            });

            this.$watch('category', () => {
                this.page = 1;
            });
        },

        resetFilters() {
            this.query = '';
            this.category = 'All';
            this.sort = 'name-asc';
            this.page = 1;
        },

        filtered() {
            const query = this.query.trim().toLowerCase();

            let result = this.items.filter((item) => {
                const matchesQuery =
                    item.name.toLowerCase().includes(query) ||
                    item.sku.toLowerCase().includes(query);

                const matchesCategory =
                    this.category === 'All' || item.category === this.category;

                return matchesQuery && matchesCategory;
            });

            result.sort((a, b) => {
                if (this.sort === 'name-asc') return a.name.localeCompare(b.name);
                if (this.sort === 'name-desc') return b.name.localeCompare(a.name);
                if (this.sort === 'price-asc') return a.price - b.price;
                if (this.sort === 'price-desc') return b.price - a.price;
                if (this.sort === 'stock-asc') return a.stock - b.stock;
                if (this.sort === 'stock-desc') return b.stock - a.stock;
                if (this.sort === 'date-desc') return new Date(b.added) - new Date(a.added);
                if (this.sort === 'date-asc') return new Date(a.added) - new Date(b.added);

                return 0;
            });

            return result;
        },

        pages() {
            return Math.max(1, Math.ceil(this.filtered().length / this.perPage));
        },

        paginated() {
            const start = (this.page - 1) * this.perPage;
            return this.filtered().slice(start, start + this.perPage);
        },

        pagesArray() {
            return Array.from({ length: this.pages() }, (_, index) => index + 1);
        },

        prevPage() {
            if (this.page > 1) {
                this.page -= 1;
            }
        },

        nextPage() {
            if (this.page < this.pages()) {
                this.page += 1;
            }
        },

        stockLabel(stock) {
            if (stock === 0) return 'Out of stock';
            if (stock < 10) return 'Low stock';
            return 'In stock';
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(value);
        },
    };
}
