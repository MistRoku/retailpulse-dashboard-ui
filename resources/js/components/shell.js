export function shell() {
    return {
        mobileNavOpen: false,
        sidebarCollapsed: window.rpStorage.read('retailpulse.sidebar.collapsed', false),
        contrastHigh: window.rpStorage.read('retailpulse.contrast.high', false),
        notificationsOpen: false,
        userMenuOpen: false,
        globalSearchOpen: false,
        searchQuery: '',
        searchResults: [],
        searching: false,
        unreadCount: 3,

        init() {
            this.applyContrast();
        },

        toggleMobileNav() {
            this.mobileNavOpen = !this.mobileNavOpen;
        },

        closeMobileNav() {
            this.mobileNavOpen = false;
        },

        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            window.rpStorage.write('retailpulse.sidebar.collapsed', this.sidebarCollapsed);
        },

        toggleContrast() {
            this.contrastHigh = !this.contrastHigh;
            window.rpStorage.write('retailpulse.contrast.high', this.contrastHigh);
            this.applyContrast();
        },

        applyContrast() {
            document.documentElement.dataset.contrast = this.contrastHigh ? 'high' : 'normal';
        },

        toggleNotifications() {
            this.notificationsOpen = !this.notificationsOpen;
            this.userMenuOpen = false;

            if (this.notificationsOpen) {
                this.unreadCount = 0;
            }
        },

        toggleUserMenu() {
            this.userMenuOpen = !this.userMenuOpen;
            this.notificationsOpen = false;
        },

        runSearch() {
            this.searching = true;

            window.setTimeout(() => {
                this.searching = false;
                this.searchResults = [
                    { label: 'Classic Cotton Tee', type: 'Product', url: '/products' },
                    { label: 'Priya Nair', type: 'Staff', url: '/staff' },
                    { label: 'Sales Summary', type: 'Report', url: '/reports' },
                ].filter((item) => {
                    return item.label.toLowerCase().includes(this.searchQuery.toLowerCase());
                });
            }, 300);
        },
    };
}
