<?php

namespace App\Http\Controllers;

use App\Support\RetailPulseData;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
        {
            return view('reports.index', [
                'reportTypes' => RetailPulseData::reportTypes(),
                'summaries' => RetailPulseData::reportSummaries(),
                'rows' => [
                    'sales-summary' => RetailPulseData::reportRows('sales-summary'),
                    'inventory-valuation' => RetailPulseData::reportRows('inventory-valuation'),
                    'staff-performance' => RetailPulseData::reportRows('staff-performance'),
                    'branch-comparison' => RetailPulseData::reportRows('branch-comparison'),
                ],
                'comparisonSeries' => RetailPulseData::comparisonSeries(),
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Reports', 'url' => route('reports.index')],
                ],
            ]);
        }
}
