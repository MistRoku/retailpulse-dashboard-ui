import Alpine from 'alpinejs';

// CHART.JS SETUP
// Register only the controllers needed to reduce bundle size (Tree Shaking).
import { createIcons, icons } from 'lucide';

import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    BarController,
    BarElement,
    Tooltip,
    Legend,
} from 'chart.js';

import { shell } from './components/shell';
import { dashboardHome } from './components/dashboard';
import { productCatalog } from './components/product-catalog';
import { staffManager } from './components/staff-manager';
import { posTerminal } from './components/pos-terminal';
import { reportsScreen } from './components/reports';
import { settingsForms } from './components/settings-forms';

Chart.register(
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    BarController,
    BarElement,
    Tooltip,
    Legend
);

// Set global defaults for charts to match the monochrome design system.
Chart.defaults.font.family = '"Public Sans", ui-sans-serif, system-ui, sans-serif';
Chart.defaults.color = '#4B5563';
Chart.defaults.borderColor = '#E5E7EB';

window.Chart = Chart;

// LUCIDE ICONS INITIALIZATION
// Lucide replaces SVG placeholders with actual icons.
// We expose this function so dynamic content (like search results) can trigger re-rendering
window.refreshLucideIcons = function refreshLucideIcons() {
    createIcons({ icons });
};

// LOCAL STORAGE HELPER
// Wraps localStorage with error handling (private browsing modes often throw errors).
// Provides a safe API for persisting UI state (sidebar collapse, contrast mode).
window.rpStorage = {
    read(key, fallback) {
        try {
            const raw = window.localStorage.getItem(key);

            if (raw === null) {
                return fallback;
            }

            return JSON.parse(raw);
        } catch (error) {
            return fallback;
        }
    },

    write(key, value) {
        try {
            window.localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            // Storage can fail in private browsing modes.
        }
    },
};

// REGISTER ALPINE DATA MAGICS
// Mapping JS functions to x-data attributes used in Blade templates.
document.addEventListener('alpine:init', () => {
    Alpine.data('shell', shell);
    Alpine.data('dashboardHome', dashboardHome);
    Alpine.data('productCatalog', productCatalog);
    Alpine.data('staffManager', staffManager);
    Alpine.data('posTerminal', posTerminal);
    Alpine.data('reportsScreen', reportsScreen);
    Alpine.data('settingsForms', settingsForms);
});

Alpine.start();

// Initial Icon Render
window.refreshLucideIcons();
