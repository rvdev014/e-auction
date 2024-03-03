<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home');
    }
}
