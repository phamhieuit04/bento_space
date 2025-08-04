<?php

namespace App\Http\Controllers;

use App\Services\Google\Drive\InfoService;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct(private InfoService $infoService)
    {
    }

    public function info(Request $request, $id)
    {
        return view('pages.drive.info', [
            'file' => $this->infoService->show($id)
        ]);
    }

    public function stream(Request $request, $id)
    {
        return $this->infoService->stream($id);
    }

    public function download(Request $request, $id)
    {
        return $this->infoService->download($id);
    }

    public function rename(Request $request, $id)
    {
        $params = $request->all();
        if ($this->infoService->rename($id, $params['name'])) {
            return redirect()->back();
        }
        throw new \Exception('Something went wrong...');
    }
}
