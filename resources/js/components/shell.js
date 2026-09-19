export function shell() {
    return {
         // STATE: Navigation
        mobileNavOpen: false,

        // STATE: Persisted Preferences
        // Initialized from LocalStorage to restore user session context immediately.
        sidebarCollapsed: window.rpStorage.read('retailpulse.sidebar.collapsed', false),
        contrastHigh: window.rpStorage.read('retailpulse.contrast.high', false),

        // STATE: Dropdown Menus
        notificationsOpen: false,
        userMenuOpen: false,

        // STATE: Search
        globalSearchOpen: false,
        searchQuery: '',
        searchResults: [],
        searching: false,
        unreadCount: 3,

        init() {
            // Apply persisted contrast setting on load to prevent FOUC (Flash of Unsty
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
            // Persist state immediately so it survives page reloads/navigation
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
            // DEBOUNCE STRATEGY
            // In a real app, this would hit an API. Here, we simulate latency to show Skele
            this.searching = true;

            window.setTimeout(() => {
                this.searching = false;
                // MOCK FILTERING LOGIC
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
