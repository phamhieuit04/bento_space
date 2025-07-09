<?php

namespace App\Services\Auth;

use App\Facades\Google\Google;
use App\Models\GoogleToken;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(private UserRepositoryInterface $userRepo)
    {
    }

    public function signin(string $code)
    {
        $accessToken = Google::getAccessToken($code);
        $googleUser = Google::getAccountInfo($accessToken);
        $user = $this->userRepo->firstOrCreate(['email' => $googleUser['email']], [
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'email_verified_at' => now(),
            'google_token' => $accessToken
        ]);
        Auth::login($user);
        return true;
    }
}