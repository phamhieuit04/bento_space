<?php

namespace App\Services\Auth;

use App\Facades\Google\Google;
use App\Models\GoogleToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(string $code)
    {
        $accessToken = Google::getAccessToken($code);
        $googleUser = Google::getAccountInfo($accessToken);
        $user = User::firstOrCreate(['email' => $googleUser['email']], [
            'name' => $googleUser['name'],
            'email' => $googleUser['email']
        ]);
        $user->google_token = $accessToken;
        $user->touch();
        Auth::login($user);
        return true;
    }
}