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
        GoogleToken::updateOrCreate(['user_id' => $user->id], [
            'token' => $accessToken
        ]);
        Auth::login($user);
        return true;
    }
}