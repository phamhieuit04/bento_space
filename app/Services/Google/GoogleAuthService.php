<?php

namespace App\Services\Google;

use App\Exceptions\GoogleException;
use Illuminate\Support\Facades\Http;

class GoogleAuthService
{
    const GOOGLE_OAUTH2_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    const GOOGLE_API_TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const GOOGLE_USER_INFO_URL = 'https://www.googleapis.com/oauth2/v3/userinfo';
    const GOOGLE_SCOPE_DRIVE = 'https://www.googleapis.com/auth/drive';

    public function getOAuthUrl()
    {
        $url = self::GOOGLE_OAUTH2_URL .
            '?client_id=' . env('GOOGLE_CLIENT_ID') .
            '&redirect_uri=' . env('GOOGLE_REDIRECT_URL') .
            '&response_type=code' .
            '&scope=email profile openid ' . self::GOOGLE_SCOPE_DRIVE .
            '&prompt=select_account consent' .
            '&access_type=offline';
        return $url;
    }

    public function getToken(string $code)
    {
        $response = Http::asForm()->post(self::GOOGLE_API_TOKEN_URL, [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => env('GOOGLE_REDIRECT_URL')
        ]);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function refreshToken(string $token)
    {
        $response = Http::asForm()->post(self::GOOGLE_API_TOKEN_URL, [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $token
        ]);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }

    public function getAccountInfo(string $accessToken)
    {
        $response = Http::withToken($accessToken)->get(self::GOOGLE_USER_INFO_URL);
        if ($response->failed()) {
            throw new GoogleException($response);
        }
        return $response->collect();
    }
}