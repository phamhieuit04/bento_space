<?php

namespace App\Http\Controllers;

use App\Facades\Google\Google;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function auth()
    {
        return redirect()->away(Google::getOAuthUrl());
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');
        if ($this->authService->signin($request, $code)) {
            return redirect('/dashboard');
        }
        return redirect('/');
    }

    public function refreshToken()
    {
        $this->authService->refreshToken(Auth::user()->refresh_token);
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return redirect('/');
    }
}
