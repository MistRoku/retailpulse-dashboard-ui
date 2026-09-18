<?php

namespace App\Http\Controllers;

use App\Support\RetailPulseData;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function terminal()
        {
            return view('pos.terminal', [
                'products' => RetailPulseData::products(),
                'categories' => RetailPulseData::categories(),
                'heldOrders' => RetailPulseData::heldOrders(),
                'taxRate' => 7.5,
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Point of Sale', 'url' => route('pos.terminal')],
                ],
            ]);
        }
}
