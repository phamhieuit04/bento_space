<?php

namespace App\Http\Controllers;

use App\Facades\Google\Google;
use App\Facades\Google\GoogleDrive;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function googleAuth()
    {
        return redirect()->away(Google::getOAuthUrl());
    }

    public function googleCallback(Request $request)
    {
        $code = $request->input('code');
        if ($this->authService->login($code)) {
            return redirect('index');
        }
        return redirect('/');
    }
}
