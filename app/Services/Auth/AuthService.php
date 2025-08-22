<?php

namespace App\Services\Auth;

use App\Facades\Google\GoogleAuthFacade;
use App\Facades\Google\GoogleDriveFacade;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(private UserRepositoryInterface $userRepo) {}

    public function getOAuthUrl()
    {
        return GoogleAuthFacade::getOAuthUrl();
    }

    public function signin(Request $request, string $code)
    {
        try {
            $response = GoogleAuthFacade::getToken($code);
            $googleUser = GoogleAuthFacade::getAccountInfo($response['access_token']);
            $user = $this->userRepo->updateOrCreate(['email' => $googleUser['email']], [
                'name'          => $googleUser['name'],
                'email'         => $googleUser['email'],
                'access_token'  => $response['access_token'],
                'refresh_token' => $response['refresh_token'],
            ]);
            Auth::login($user);
            $request->session()->regenerate();
            $user->root_id = GoogleDriveFacade::getRootId();
            $user->touch();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function refreshToken(string $token)
    {
        $response = GoogleAuthFacade::refreshToken($token);
        $update = $this->userRepo->update([
            'access_token' => $response['access_token']
        ], Auth::id());

        return !blank($update) ? true : false;
    }

    public function logout(Request $request)
    {
        try {
            $this->userRepo->update([
                'access_token'  => null,
                'refresh_token' => null
            ], Auth::id());
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
