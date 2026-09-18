<?php

namespace App\Http\Controllers;

use App\Support\RetailPulseData;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
        {
            return view('products.index', [
                'products' => RetailPulseData::products(),
                'categories' => RetailPulseData::categories(),
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Products', 'url' => route('products.index')],
                ],
            ]);
        }
}
