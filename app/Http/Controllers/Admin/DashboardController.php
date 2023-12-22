<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    private $dashboardService;

    /**
     * BrandController constructor.
     *
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    /**
     * Displays a dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard.index', $this->dashboardService->index());
    }
}
