<?php

namespace App\Http\Controllers\Drive;

use App\Http\Controllers\Controller;
use App\Services\Google\Drive\StarService;

class StarController extends Controller
{
    public function __construct(private StarService $starService) {}

    public function index()
    {
        return view('pages.drive.dashboard', [
            'data' => $this->starService->all()
        ]);
    }
}
