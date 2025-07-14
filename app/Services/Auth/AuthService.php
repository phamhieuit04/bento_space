<?php

namespace App\Services\Auth;

use App\Facades\Google\Google;
use App\Facades\Google\GoogleDrive;
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
        $response = Google::getToken($code);
        $googleUser = Google::getAccountInfo($response['access_token']);
        $user = $this->userRepo->updateOrCreate(['email' => $googleUser['email']], [
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
        ]);
        Auth::login($user);
        $user->root_id = GoogleDrive::getRootId();
        $user->touch();
        return true;
    }

    public function refreshToken(string $token)
    {
        $response = Google::refreshToken($token);
        $update = $this->userRepo->update([
            'access_token' => $response['access_token']
        ], Auth::id());
        return !blank($update) ? true : false;
    }

    public function logout()
    {
        Auth::logout();
        return true;
    }
}