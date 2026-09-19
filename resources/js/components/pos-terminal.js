export function posTerminal(products, taxRate, heldOrders) {
    return {
        loading: true,
        query: '',
        category: 'All',
        tab: 'cart',
        taxRate: taxRate,
        products: products.map((product) => ({
            ...product,
            initials: product.name
                .split(' ')
                .slice(0, 2)
                .map((part) => part[0])
                .join('')
                .toUpperCase(),
        })),
        cart: [],
        discount: 0,
        paymentMethod: 'Cash',
        heldOrders: heldOrders,
        receiptOpen: false,
        lastOrder: null,

        init() {
            window.setTimeout(() => {
                this.loading = false;
            }, 300);
        },

        filteredProducts() {
            const query = this.query.trim().toLowerCase();

            return this.products.filter((product) => {
                const matchesQuery =
                    product.name.toLowerCase().includes(query) ||
                    product.sku.toLowerCase().includes(query);

                const matchesCategory =
                    this.category === 'All' || product.category === this.category;

                return matchesQuery && matchesCategory;
            });
        },

        addToCart(product) {
            // UPSERT LOGIC: Check if item exists, increment qty, else push new
            const existing = this.cart.find((line) => line.id === product.id);

            if (existing) {
                existing.qty += 1;
                return;
            }

            this.cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                qty: 1,
            });
        },

        increment(line) {
            line.qty += 1;
        },

        decrement(line) {
            if (line.qty > 1) {
                line.qty -= 1;
            } else {
                this.removeLine(line);
            }
        },

        removeLine(line) {
            this.cart = this.cart.filter((item) => item.id !== line.id);
        },

        // REACTIVE GETTERS
        // These automatically recalculate whenever `cart`, `discount`, or `taxRate` chan
        get subtotal() {
            return this.round(this.cart.reduce((sum, line) => sum + line.price * line.qty, 0));
        },

        get taxableAmount() {
            return this.round(Math.max(0, this.subtotal - (this.discount || 0)));
        },

        get taxAmount() {
            return this.round(this.taxableAmount * (this.taxRate / 100));
        },

        get total() {
            return this.round(this.taxableAmount + this.taxAmount);
        },

        round(value) {
            return Math.round(value * 100) / 100;
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(value || 0);
        },

        holdOrder() {
            if (this.cart.length === 0) {
                return;
            }

            // SNAPSHOT CART STATE
            const order = {
                id: 'HOLD-' + Math.floor(1000 + Math.random() * 9000),
                customer: 'Walk-in',
                items: this.cart.reduce((sum, line) => sum + line.qty, 0),
                total: this.formatCurrency(this.total),
                lines: JSON.parse(JSON.stringify(this.cart)),
                discount: this.discount,
                paymentMethod: this.paymentMethod,
            };

            this.heldOrders.unshift(order);
            window.rpStorage.write('retailpulse.pos.heldOrders', this.heldOrders);

            // RESET CURRENT SESSION
            this.cart = [];
            this.discount = 0;
            this.tab = 'held';
        },

        resumeOrder(order) {
            this.cart = JSON.parse(JSON.stringify(order.lines || []));
            this.discount = order.discount || 0;
            this.paymentMethod = order.paymentMethod || 'Cash';
            this.heldOrders = this.heldOrders.filter((item) => item.id !== order.id);
            window.rpStorage.write('retailpulse.pos.heldOrders', this.heldOrders);
            this.tab = 'cart';
        },

        dropOrder(orderId) {
            this.heldOrders = this.heldOrders.filter((order) => order.id !== orderId);
            window.rpStorage.write('retailpulse.pos.heldOrders', this.heldOrders);
        },

        completeSale() {
            if (this.cart.length === 0) {
                return;
            }

            this.lastOrder = {
                reference: 'TX-' + Math.floor(98200 + Math.random() * 800),
                lines: JSON.parse(JSON.stringify(this.cart)),
                subtotal: this.subtotal,
                discount: this.discount || 0,
                tax: this.taxAmount,
                total: this.total,
                paymentMethod: this.paymentMethod,
            };

            this.receiptOpen = true;
        },

        printReceipt() {
            window.print();
        }, // Triggers browser native print dialog

        newSale() {
            this.cart = [];
            this.discount = 0;
            this.paymentMethod = 'Cash';
            this.lastOrder = null;
            this.receiptOpen = false;
            this.tab = 'cart';
        },
    };
}
