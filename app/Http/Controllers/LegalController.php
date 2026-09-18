<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function terms()
        {
            return view('legal.terms', [
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Terms of Service', 'url' => route('legal.terms')],
                ],
            ]);
        }

        public function privacy()
        {
            return view('legal.privacy', [
                'breadcrumbs' => [
                    ['label' => 'Dashboard', 'url' => route('dashboard')],
                    ['label' => 'Privacy Policy', 'url' => route('legal.privacy')],
                ],
            ]);
        }
}
