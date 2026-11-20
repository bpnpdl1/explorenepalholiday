<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Dashboard\BuildAdminDashboardDataAction;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(BuildAdminDashboardDataAction $buildDashboard): View
    {
        return view('admin.dashboard', $buildDashboard->handle());
    }
}
