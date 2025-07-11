<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index()
    {
        $data = $this->dashboardService->all();
        return view('dashboard', [
            'folders' => $data['folders'],
            'files' => $data['files']
        ]);
    }

    public function sync()
    {
        $this->dashboardService->sync();
        return redirect()->back();
    }
}
