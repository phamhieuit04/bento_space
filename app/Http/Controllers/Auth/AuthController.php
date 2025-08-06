<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $url = $this->authService->getOAuthUrl();
        if (!blank($url)) {
            return redirect()->away($url);
        }
        throw new \Exception('Something went wrong...');
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');
        if ($this->authService->signin($request, $code)) {
            return redirect('/drive/dashboard');
        }
        return redirect('/');
    }

    public function refreshToken()
    {
        if ($this->authService->refreshToken(Auth::user()->refresh_token)) {
            return redirect('/drive/dashboard');
        }
        throw new \Exception('Something went wrong...');
    }

    public function logout(Request $request)
    {
        if ($this->authService->logout($request)) {
            return redirect('/');
        }
        throw new \Exception('Something went wrong...');
    }
}
