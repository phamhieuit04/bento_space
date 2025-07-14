<?php

namespace App\Http\Controllers;

use App\Facades\Google\GoogleDrive;
use App\Services\Dashboard\InfoService;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct(private InfoService $infoService)
    {
    }

    public function info(Request $request, $id)
    {
        return view('info', [
            'file' => $this->infoService->show($id)
        ]);
    }

    public function download(Request $request, $id)
    {
        return $this->infoService->download($id);
    }
}
