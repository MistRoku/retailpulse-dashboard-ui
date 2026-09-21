<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Support\RetailPulseData;

class StaffController extends Controller
{
    public function index()
        {
            return view('staff.index', [
                'staff' => RetailPulseData::staff(),
                'branches' => RetailPulseData::branches(),
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Staff', 'url' => route('staff.index')],
                ],
            ]);
        }
}
