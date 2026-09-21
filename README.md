# RetailPulse Dashboard UI

> **Frontend architecture demo.** This is a fictional admin dashboard built to showcase Laravel Blade, Tailwind CSS, and Alpine.js patterns. All data is synthetic and hardcoded via `RetailPulseData` — there is no database, no API, and no authentication layer. Not intended for production use.

![RetailPulse Dashboard](./screenshots/dashboard.png)

## 🚀 Tech Stack

*   **Framework:** Laravel 11
*   **Styling:** Tailwind CSS 3.4
*   **Interactivity:** Alpine.js 3
*   **Build Tool:** Vite
*   **Charts:** Chart.js 4
*   **Icons:** Lucide Icons
*   **Font:** Public Sans (@fontsource)

## 🎨 Design Philosophy

This project adheres to a strict **"Radical Minimalism"** design system:
*   **No Shadows:** Depth is created via borders and color contrast.
*   **No Gradients:** Flat, solid colors only.
*   **Square Corners:** `border-radius: 0` enforced globally.
*   **Pure White Cards:** On a warm off-white (`#FDFBF7`) background.
*   **Organic Palette:** Sage Green, Warm Sand, Pale Gold, and Clay accents.
*   **Accessibility First:** WCAG AA compliant, visible focus states, semantic HTML.

## ⚡ Features

1.  **Dynamic Dashboard:** Real-time KPIs, Chart.js visualizations, and recent activity feeds.
2.  **Product Catalog:** Client-side filtering, sorting, pagination, and List/Grid view toggles.
3.  **Staff Management:** CRUD modals, role-based badges, and active status toggles.
4.  **POS Terminal:** Reactive cart calculations, tax/discount logic, held orders, and printable receipts.
5.  **Advanced Reports:** Date-range analysis, period comparisons, and CSV exports.
6.  **Settings Hub:** Branch configuration, notification preferences, and profile management.
7.  **Legal Compliance:** Dedicated Terms of Service and Privacy Policy pages.

## 🛠️ Installation & Setup

### Prerequisites
*   PHP >= 8.2
*   Composer
*   Node.js >= 20
*   npm

### Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/MistRoku/retailpulse-dashboard-ui.git
    cd retailpulse-dashboard-ui
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Set up environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

5.  **Run Development Servers:**
    Open two terminals.
    
    Terminal 1 (Backend):
    ```bash
    php artisan serve
    ```
    
    Terminal 2 (Frontend Assets):
    ```bash
    npm run dev
    ```

6.  **Visit the App:**
    Navigate to `http://localhost:8000` in your browser.

## 📂 Project Structure


resources/
├── css/
│   └── app.css          # Global styles, Tailwind layers, component classes
├── js/
│   ├── app.js           # Entry point, Alpine registration, Chart.js setup
│   └── components/      # Modular Alpine logic (shell, dashboard, pos, etc.)
└── views/
    ├── layouts/         # Master Blade layout
    ├── components/      # Reusable Blade UI parts (buttons, modals, badges)
    ├── dashboard/       # Home screen views
    ├── products/        # Inventory management views
    ├── staff/           # Team management views
    ├── pos/             # Point of Sale terminal views
    ├── reports/         # Analytics views
    ├── settings/        # Configuration views
    └── legal/           # ToS and Privacy Policy
app/
└── Support/
    └── RetailPulseData.php # Mock data provider (Repository Pattern Simulation)

    
## ♿ Accessibility

*   All interactive elements have visible focus outlines (`outline: 2px solid #2C3E30`).
*   Icon-only buttons include `aria-label` attributes.
*   Tables use proper `<th scope="col">` semantics.
*   Color contrast ratios meet WCAG AA standards.
*   Skeleton loaders are marked `aria-hidden="true"` to prevent screen reader noise.

## 📄 License

This project is for educational and portfolio purposes. 
Licensed under MIT.

---
*RetailPulse is a fictional brand. All data is synthetic. This project demonstrates frontend architecture patterns only — it is not a functioning application.*
