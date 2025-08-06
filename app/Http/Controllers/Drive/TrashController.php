<?php

namespace App\Http\Controllers\Drive;

use App\Http\Controllers\Controller;
use App\Services\Google\Drive\TrashService;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function __construct(private TrashService $trashService)
    {
    }

    public function index()
    {
        return view('pages.drive.dashboard', [
            'data' => $this->trashService->all()
        ]);
    }

    public function trash(Request $request, $id)
    {
        if ($this->trashService->trash($id)) {
            return redirect()->back();
        }
        throw new \Exception('Something went wrong...');
    }
}
