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
        return view('pages.drive.dashboard', [
            'data' => $this->dashboardService->all()
        ]);
    }

    public function sync()
    {
        if ($this->dashboardService->sync()) {
            return redirect()->back();
        }
        throw new \Exception('Something went wrong...');
    }

    public function show($id)
    {
        return view('pages.drive.dashboard', [
            'data' => $this->dashboardService->show($id)
        ]);
    }

    public function search(Request $request)
    {
        $searchKey = $request->input('search_key');
        if (blank($searchKey) || !isset($searchKey)) {
            return redirect('/drive/dashboard');
        }
        return view('pages.drive.dashboard', [
            'data' => $this->dashboardService->search($searchKey)
        ]);
    }
}
