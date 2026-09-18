<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class RetailPulseData
{
    public static function kpis(): array
    {
        return [
            [
                'title' => 'Total Revenue Today',
                'value' => '$18,420.50',
                'change' => '12.4%',
                'direction' => 'increase',
                'comparison' => 'versus yesterday',
            ],
            [
                'title' => 'Total Transactions Today',
                'value' => '312',
                'change' => '4.1%',
                'direction' => 'increase',
                'comparison' => 'versus yesterday',
            ],
            [
                'title' => 'Active Staff Members Online',
                'value' => '27',
                'change' => '2',
                'direction' => 'decrease',
                'comparison' => 'versus morning shift',
            ],
            [
                'title' => 'Low Stock Alerts',
                'value' => '9',
                'change' => '3',
                'direction' => 'increase',
                'comparison' => 'since last audit',
            ],
        ];
    }

    public static function revenueSeries(): array
    {
        $labels = [];
        $values = [12400, 15800, 14250, 18100, 16900, 19450, 18420];

        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::today()->subDays($i)->format('D d');
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    public static function topProducts(): array
    {
        return [
            ['name' => 'Classic Cotton Tee', 'quantity' => 184],
            ['name' => 'Denim Trucker Jacket', 'quantity' => 142],
            ['name' => 'Leather Crossbody Bag', 'quantity' => 119],
            ['name' => 'Wool Blend Scarf', 'quantity' => 96],
            ['name' => 'Canvas Sneaker Low', 'quantity' => 88],
        ];
    }

    public static function recentTransactions(): array
    {
        return [
            ['reference' => 'TX-98231', 'customer' => 'Amara Osei', 'amount' => '$142.00', 'status' => 'Completed', 'channel' => 'Card', 'time' => '10:42'],
            ['reference' => 'TX-98230', 'customer' => 'Liam Carter', 'amount' => '$58.50', 'status' => 'Pending', 'channel' => 'Cash', 'time' => '10:39'],
            ['reference' => 'TX-98229', 'customer' => 'Sofia Reyes', 'amount' => '$210.75', 'status' => 'Completed', 'channel' => 'E-Wallet', 'time' => '10:31'],
            ['reference' => 'TX-98228', 'customer' => 'Noah Kim', 'amount' => '$36.00', 'status' => 'Refunded', 'channel' => 'Card', 'time' => '10:24'],
            ['reference' => 'TX-98227', 'customer' => 'Emma Diallo', 'amount' => '$94.20', 'status' => 'Completed', 'channel' => 'Cash', 'time' => '10:18'],
            ['reference' => 'TX-98226', 'customer' => 'Oliver Grant', 'amount' => '$178.90', 'status' => 'Failed', 'channel' => 'Card', 'time' => '10:11'],
            ['reference' => 'TX-98225', 'customer' => 'Mia Thompson', 'amount' => '$62.40', 'status' => 'Completed', 'channel' => 'E-Wallet', 'time' => '10:04'],
            ['reference' => 'TX-98224', 'customer' => 'Ethan Brooks', 'amount' => '$129.00', 'status' => 'Pending', 'channel' => 'Card', 'time' => '09:57'],
            ['reference' => 'TX-98223', 'customer' => 'Ava Martinez', 'amount' => '$45.80', 'status' => 'Completed', 'channel' => 'Cash', 'time' => '09:49'],
            ['reference' => 'TX-98222', 'customer' => 'Lucas Nguyen', 'amount' => '$203.10', 'status' => 'Completed', 'channel' => 'E-Wallet', 'time' => '09:41'],
        ];
    }

    public static function categories(): array
    {
        return [
            'All',
            'Apparel',
            'Footwear',
            'Accessories',
            'Bags',
            'Outerwear',
        ];
    }

    public static function products(): array
    {
        return [
            ['id' => 1, 'name' => 'Classic Cotton Tee', 'sku' => 'TEE-001', 'price' => 24.00, 'stock' => 142, 'category' => 'Apparel', 'added' => '2026-08-01'],
            ['id' => 2, 'name' => 'Denim Trucker Jacket', 'sku' => 'JKT-014', 'price' => 89.00, 'stock' => 8, 'category' => 'Outerwear', 'added' => '2026-08-03'],
            ['id' => 3, 'name' => 'Leather Crossbody Bag', 'sku' => 'BAG-055', 'price' => 120.00, 'stock' => 0, 'category' => 'Bags', 'added' => '2026-08-05'],
            ['id' => 4, 'name' => 'Wool Blend Scarf', 'sku' => 'ACC-021', 'price' => 35.00, 'stock' => 44, 'category' => 'Accessories', 'added' => '2026-08-07'],
            ['id' => 5, 'name' => 'Canvas Sneaker Low', 'sku' => 'SHO-090', 'price' => 65.00, 'stock' => 19, 'category' => 'Footwear', 'added' => '2026-08-09'],
            ['id' => 6, 'name' => 'Ribbed Beanie', 'sku' => 'ACC-031', 'price' => 18.00, 'stock' => 76, 'category' => 'Accessories', 'added' => '2026-08-10'],
            ['id' => 7, 'name' => 'Oxford Shirt', 'sku' => 'TEE-044', 'price' => 48.00, 'stock' => 5, 'category' => 'Apparel', 'added' => '2026-08-11'],
            ['id' => 8, 'name' => 'Chelsea Boot', 'sku' => 'SHO-112', 'price' => 145.00, 'stock' => 12, 'category' => 'Footwear', 'added' => '2026-08-12'],
            ['id' => 9, 'name' => 'Weekender Duffel', 'sku' => 'BAG-078', 'price' => 160.00, 'stock' => 7, 'category' => 'Bags', 'added' => '2026-08-13'],
            ['id' => 10, 'name' => 'Quilted Vest', 'sku' => 'JKT-062', 'price' => 78.00, 'stock' => 31, 'category' => 'Outerwear', 'added' => '2026-08-14'],
            ['id' => 11, 'name' => 'Linen Trouser', 'sku' => 'TEE-088', 'price' => 59.00, 'stock' => 22, 'category' => 'Apparel', 'added' => '2026-08-15'],
            ['id' => 12, 'name' => 'Suede Loafer', 'sku' => 'SHO-131', 'price' => 110.00, 'stock' => 3, 'category' => 'Footwear', 'added' => '2026-08-16'],
        ];
    }

    public static function branches(): array
    {
        return [
            'All Branches',
            'Downtown Flagship',
            'Riverside Mall',
            'Northgate Plaza',
            'Airport Terminal 2',
        ];
    }

    public static function staff(): array
    {
        return [
            ['id' => 1, 'name' => 'Nadia Rahman', 'email' => 'nadia.rahman@retailpulse.test', 'role' => 'Admin', 'branch' => 'Downtown Flagship', 'active' => true, 'initials' => 'NR'],
            ['id' => 2, 'name' => 'Marcus Lee', 'email' => 'marcus.lee@retailpulse.test', 'role' => 'Manager', 'branch' => 'Riverside Mall', 'active' => true, 'initials' => 'ML'],
            ['id' => 3, 'name' => 'Priya Nair', 'email' => 'priya.nair@retailpulse.test', 'role' => 'Cashier', 'branch' => 'Northgate Plaza', 'active' => true, 'initials' => 'PN'],
            ['id' => 4, 'name' => 'Jonas Weber', 'email' => 'jonas.weber@retailpulse.test', 'role' => 'Manager', 'branch' => 'Airport Terminal 2', 'active' => false, 'initials' => 'JW'],
            ['id' => 5, 'name' => 'Chloe Dubois', 'email' => 'chloe.dubois@retailpulse.test', 'role' => 'Cashier', 'branch' => 'Downtown Flagship', 'active' => true, 'initials' => 'CD'],
            ['id' => 6, 'name' => 'Samuel Okoro', 'email' => 'samuel.okoro@retailpulse.test', 'role' => 'Cashier', 'branch' => 'Riverside Mall', 'active' => false, 'initials' => 'SO'],
        ];
    }

    public static function reportTypes(): array
    {
        return [
            'sales-summary' => 'Sales Summary',
            'inventory-valuation' => 'Inventory Valuation',
            'staff-performance' => 'Staff Performance',
            'branch-comparison' => 'Branch Comparison',
        ];
    }

    public static function reportSummaries(): array
    {
        return [
            'sales-summary' => [
                ['title' => 'Net Sales', 'value' => '$126,480.00', 'change' => '8.2%', 'direction' => 'increase'],
                ['title' => 'Average Basket', 'value' => '$73.18', 'change' => '1.4%', 'direction' => 'increase'],
                ['title' => 'Returns', 'value' => '$4,120.00', 'change' => '0.8%', 'direction' => 'decrease'],
                ['title' => 'Discount Cost', 'value' => '$6,940.00', 'change' => '2.1%', 'direction' => 'increase'],
            ],
            'inventory-valuation' => [
                ['title' => 'Stock Value', 'value' => '$318,900.00', 'change' => '3.0%', 'direction' => 'decrease'],
                ['title' => 'Slow Moving Items', 'value' => '42', 'change' => '6', 'direction' => 'increase'],
                ['title' => 'Out of Stock Items', 'value' => '9', 'change' => '2', 'direction' => 'increase'],
                ['title' => 'Reorder Needed', 'value' => '17', 'change' => '4', 'direction' => 'decrease'],
            ],
            'staff-performance' => [
                ['title' => 'Transactions Processed', 'value' => '2,481', 'change' => '5.5%', 'direction' => 'increase'],
                ['title' => 'Average Speed', 'value' => '2m 14s', 'change' => '9s', 'direction' => 'decrease'],
                ['title' => 'Upsell Rate', 'value' => '18.6%', 'change' => '1.2%', 'direction' => 'increase'],
                ['title' => 'Void Events', 'value' => '23', 'change' => '3', 'direction' => 'decrease'],
            ],
            'branch-comparison' => [
                ['title' => 'Best Branch', 'value' => 'Downtown Flagship', 'change' => '$42,180', 'direction' => 'increase'],
                ['title' => 'Growth Leader', 'value' => 'Riverside Mall', 'change' => '11.8%', 'direction' => 'increase'],
                ['title' => 'Lowest Returns', 'value' => 'Northgate Plaza', 'change' => '1.1%', 'direction' => 'decrease'],
                ['title' => 'Staff Coverage', 'value' => '96%', 'change' => '2%', 'direction' => 'increase'],
            ],
        ];
    }

    public static function reportRows(string $type): array
    {
        return match ($type) {
            'inventory-valuation' => [
                ['name' => 'Classic Cotton Tee', 'quantity' => '142', 'unit cost' => '$9.20', 'value' => '$1,306.40'],
                ['name' => 'Denim Trucker Jacket', 'quantity' => '8', 'unit cost' => '$38.00', 'value' => '$304.00'],
                ['name' => 'Leather Crossbody Bag', 'quantity' => '0', 'unit cost' => '$54.00', 'value' => '$0.00'],
                ['name' => 'Wool Blend Scarf', 'quantity' => '44', 'unit cost' => '$12.50', 'value' => '$550.00'],
            ],
            'staff-performance' => [
                ['name' => 'Priya Nair', 'transactions' => '412', 'sales' => '$28,140', 'average basket' => '$68.30'],
                ['name' => 'Chloe Dubois', 'transactions' => '388', 'sales' => '$26,910', 'average basket' => '$69.35'],
                ['name' => 'Marcus Lee', 'transactions' => '301', 'sales' => '$24,880', 'average basket' => '$82.65'],
                ['name' => 'Samuel Okoro', 'transactions' => '214', 'sales' => '$14,920', 'average basket' => '$69.72'],
            ],
            'branch-comparison' => [
                ['name' => 'Downtown Flagship', 'sales' => '$42,180', 'transactions' => '512', 'returns' => '$820'],
                ['name' => 'Riverside Mall', 'sales' => '$36,940', 'transactions' => '468', 'returns' => '$1,140'],
                ['name' => 'Northgate Plaza', 'sales' => '$28,410', 'transactions' => '361', 'returns' => '$310'],
                ['name' => 'Airport Terminal 2', 'sales' => '$18,950', 'transactions' => '240', 'returns' => '$640'],
            ],
            default => [
                ['name' => 'Morning Shift', 'sales' => '$38,420', 'transactions' => '142', 'average basket' => '$70.12'],
                ['name' => 'Midday Shift', 'sales' => '$46,180', 'transactions' => '168', 'average basket' => '$74.80'],
                ['name' => 'Evening Shift', 'sales' => '$41,880', 'transactions' => '154', 'average basket' => '$72.20'],
            ],
        };
    }

    public static function comparisonSeries(): array
    {
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'current' => [12400, 15800, 14250, 18100, 16900, 19450, 18420],
            'previous' => [11800, 14200, 13900, 16400, 15800, 17900, 17250],
        ];
    }

    public static function notifications(): array
    {
        return [
            ['title' => 'Low stock alert', 'body' => 'Denim Trucker Jacket is below threshold at Downtown Flagship.', 'time' => '4 minutes ago'],
            ['title' => 'Refund approved', 'body' => 'Transaction TX-98228 was refunded successfully.', 'time' => '18 minutes ago'],
            ['title' => 'Shift reminder', 'body' => 'Evening shift handover begins at 18:00.', 'time' => '1 hour ago'],
        ];
    }

    public static function heldOrders(): array
    {
        return [
            ['id' => 'HOLD-104', 'items' => 3, 'total' => '$142.80', 'customer' => 'Walk-in'],
            ['id' => 'HOLD-105', 'items' => 1, 'total' => '$65.00', 'customer' => 'Liam Carter'],
        ];
    }
}
