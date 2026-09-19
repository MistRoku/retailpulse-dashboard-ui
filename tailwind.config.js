/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Public Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            
            // NEW COLOR PALETTE: Organic & Editorial
            colors: {
                // Core Surfaces
                surface: '#FFFFFF',      // Strict White Background
                
                // Typography & Borders (The "Ink")
                ink: {
                    DEFAULT: '#2C3E30',  // Deep Forest Charcoal (Headings, Primary Text)
                    muted: '#4A5D50',    // Softer Green-Gray (Body Text)
                    faint: '#8DA399',    // Muted Stone (Borders, Icons, Disabled States)
                },

                // Accents & Status Colors
                sage: '#A8D8B9',         // Success, Active Tabs, Positive Trends
                sand: '#F3E9D7',         // Secondary Buttons, Hover States, Table Headers
                gold: '#EAE2B7',         // Warnings, Low Stock Highlights
                clay: '#C47A65',         // Destructive Actions, Errors, Out-of-Stock
                
                // Utility Shades (for subtle backgrounds)
                'sage-light': '#F0FFF4', // Very light green tint for success badges
                'sand-dark': '#E8DDCB',  // Slightly darker sand for pressed states
            },

            // DESIGN CONSTRAINT: Radical Minimalism
            borderRadius: {
                none: '0', sm: '0', DEFAULT: '0', md: '0', lg: '0', xl: '0', '2xl': '0', '3xl': '0', full: '0',
            },

            // DESIGN CONSTRAINT: No Depth/Shadow
            boxShadow: {
                sm: 'none', DEFAULT: 'none', md: 'none', lg: 'none', xl: 'none', '2xl': 'none', inner: 'none',
            },
        },
    },
    plugins: [],
};