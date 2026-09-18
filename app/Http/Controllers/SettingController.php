<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
       {
           return view('settings.index', [
               'breadcrumbs' => [
                   ['label' => 'Dashboard', 'url' => route('dashboard')],
                   ['label' => 'Settings', 'url' => route('settings.index')],
               ],
           ]);
       }
}
