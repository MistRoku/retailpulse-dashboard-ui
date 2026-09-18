<?php

namespace App\Http\Controllers;

use App\Support\RetailPulseData;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
        {
            return view('dashboard.index', [
                'kpis' => RetailPulseData::kpis(),
                'revenueSeries' => RetailPulseData::revenueSeries(),
                'topProducts' => RetailPulseData::topProducts(),
                'transactions' => RetailPulseData::recentTransactions(),
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                ],
            ]);
        }
}
