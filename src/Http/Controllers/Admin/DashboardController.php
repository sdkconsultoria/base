<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('base::back.dashboard.index', [
        ]);
    }
}
