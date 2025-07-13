<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function index()
    {
        return view('dashboard', [
            'data' => $this->dashboardService->all()
        ]);
    }

    public function sync()
    {
        $this->dashboardService->sync();
        return redirect()->back();
    }

    public function show($id)
    {
        return view('dashboard', [
            'data' => $this->dashboardService->show($id)
        ]);
    }
}
